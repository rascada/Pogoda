<?php

namespace SyntaxError\ApiBundle\Service\Archive;

use Doctrine\ORM\EntityManager;
use SyntaxError\ApiBundle\Entity\ArchiveDayOuttemp;
use SyntaxError\ApiBundle\Entity\ArchiveDayWindgustdir;
use SyntaxError\ApiBundle\Interfaces\ArchiveDay;
use SyntaxError\ApiBundle\Interfaces\ArchiveService;
use SyntaxError\ApiBundle\Tools\RecordBuilder;

class YearService implements ArchiveService
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function highFormatter(\DateTime $dateTime, $archiveName)
    {
        $from = (new \DateTime( $dateTime->format("Y-01-01 00:00:00") ))->getTimestamp();
        $to = (new \DateTime( $dateTime->format("Y-12-31 23:59:59") ))->getTimestamp();

        $records = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDay$archiveName")
            ->createQueryBuilder('a')->where('a.datetime BETWEEN :from AND :to')
            ->setParameter('from', $from)->setParameter('to', $to)
            ->orderBy('a.datetime', 'asc')->getQuery()->getResult();
        $output = [];

        switch($archiveName) {
            case 'Windgustdir':
                foreach($records as $i => $record) {
                    if($record instanceof ArchiveDay) {
                        if( (new \DateTime())->setTimestamp( $record->getDatetime() )->format("H") != 0) continue;
                        $cnt = $record->getCount();
                        $output[] = [$record->getDatetime(), $cnt ? $record->getSum() / $cnt : 0];
                    }
                } break;

            case 'Rain':
                foreach($records as $i => $record) {
                    if($record instanceof ArchiveDay) {
                        if( (new \DateTime())->setTimestamp( $record->getDatetime() )->format("H") != 0) continue;
                        $output[] = [$record->getDatetime(), $record->getSum()];
                    }
                } break;

            default:
                foreach($records as $i => $record) {
                    if($record instanceof ArchiveDay) {
                        if( (new \DateTime())->setTimestamp( $record->getDatetime() )->format("H") != 0) continue;
                        $output[] = [$record->getDatetime(), $record->getMin(), $record->getMax()];
                    }
                } break;
        }

        return $output;
    }

    public function createTemperature(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuttemp")->findYearRecord($dateTime);
        $min = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuttemp")->findYearRecord($dateTime, false);
        if(!$max || !$min) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        $builder->set( 'min', $min->getMintime(), $min->getMin() );
        return $builder->getTemperatureRecord();
    }

    public function createHumidity(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuthumidity")->findYearRecord($dateTime);
        $min = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuthumidity")->findYearRecord($dateTime, false);
        if(!$max || !$min) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        $builder->set( 'min', $min->getMintime(), $min->getMin() );
        return $builder->getHumidityRecord();
    }

    public function createBarometer(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayBarometer")->findYearRecord($dateTime);
        $min = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayBarometer")->findYearRecord($dateTime, false);
        if(!$max || !$min) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        $builder->set( 'min', $min->getMintime(), $min->getMin() );
        return $builder->getBarometerRecord();
    }

    public function createWindSpeed(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgust")->findYearRecord($dateTime);
        if(!$max) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        return $builder->getWindSpeedRecord();
    }

    public function createWindDir(\DateTime $dateTime)
    {
        $avg = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgustdir")->avgYear($dateTime);
        $builder = new RecordBuilder();
        $builder->set( 'avg', "Średni kierunek wiatru", $avg );
        return $builder->getWindDirAvg();
    }

    public function createRain(\DateTime $dateTime)
    {
        $sum = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRain")->findYearSum($dateTime);
        $builder = new RecordBuilder();
        $builder->set( 'sum', "Suma opadów", $sum );
        return $builder->getRainRecord();
    }

    public function createRainRate(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRainrate")->findYearRecord($dateTime);
        if(!$max) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        return $builder->getRainRateRecord();
    }

}
