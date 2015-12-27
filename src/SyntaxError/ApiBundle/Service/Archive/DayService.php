<?php

namespace SyntaxError\ApiBundle\Service\Archive;

use Doctrine\ORM\EntityManager;
use SyntaxError\ApiBundle\Interfaces\ArchiveService;
use SyntaxError\ApiBundle\Tools\RecordBuilder;

class DayService implements ArchiveService
{
    private $archive;

    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->archive = $entityManager->getRepository("SyntaxErrorApiBundle:Archive");
        $this->em = $entityManager;
    }

    public function highFormatter(\DateTime $dateTime, $callName)
    {
        $callName = 'get'.ucfirst($callName);
        $archives = $this->archive->findByDay($dateTime);
        $response = [];
        foreach($archives as $archive) {
            $value = call_user_func([$archive, $callName]);
            $response[] = [($archive->getDatetime()+3600)*1000, $value ? $value : 0];
        }
        return $response;
    }

    public function createTemperature(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuttemp")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);
        if(!$record) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $record->getMaxtime(), $record->getMax() );
        $builder->set( 'min', $record->getMintime(), $record->getMin() );
        return $builder->getTemperatureRecord();
    }

    public function createHumidity(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuthumidity")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);
        if(!$record) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $record->getMaxtime(), $record->getMax() );
        $builder->set( 'min', $record->getMintime(), $record->getMin() );
        return $builder->getHumidityRecord();
    }

    public function createBarometer(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayBarometer")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);
        if(!$record) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $record->getMaxtime(), $record->getMax() );
        $builder->set( 'min', $record->getMintime(), $record->getMin() );
        return $builder->getBarometerRecord();
    }

    public function createWindSpeed(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgust")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);
        if(!$record) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $record->getMaxtime(), $record->getMax() );
        return $builder->getWindSpeedRecord();
    }

    public function createWindDir(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgustdir")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);
        if(!$record) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'avg', 'Średni kierunek wiatru', $record->getSum() / $record->getCount() );
        return $builder->getWindDirAvg();
    }

    public function createRainRate(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRainrate")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);
        if(!$record) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $record->getMaxtime(), $record->getMax() );
        return $builder->getRainRateRecord();
    }

    public function createRain(\DateTime $dateTime)
    {
        $sum = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRain")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);
        if(!$sum) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'sum', 'Suma opadów', $sum->getSum() );
        return $builder->getRainRecord();
    }
}
