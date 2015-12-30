<?php

namespace SyntaxError\ApiBundle\Service\Archive;

use Doctrine\ORM\EntityManager;
use SyntaxError\ApiBundle\Interfaces\ArchiveService;
use SyntaxError\ApiBundle\Record\RecordGenerator;

class DayService implements ArchiveService
{
    private $em;

    private $generator;

    public function __construct(EntityManager $entityManager)
    {
        $this->generator = new RecordGenerator();
        $this->em = $entityManager;
    }

    public function highFormatter(\DateTime $dateTime, $callName)
    {
        $callName = 'get'.ucfirst($callName);
        $archives = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findByDay($dateTime);
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

        return $this->generator->generateTemperature($record, $record);
    }

    public function createHumidity(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuthumidity")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);

        return $this->generator->generateHumidity($record, $record);
    }

    public function createBarometer(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayBarometer")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);
        return $this->generator->generateBarometer($record, $record);
    }

    public function createWindSpeed(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgust")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);

        return $this->generator->generateWindSpeed($record);
    }

    public function createWindDir(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgustdir")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);

        return $this->generator->generateWindDir( $record->getSum() / $record->getCount() );
    }

    public function createRainRate(\DateTime $dateTime)
    {
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRainrate")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);

        return $this->generator->generateRainRate($record);
    }

    public function createRain(\DateTime $dateTime)
    {
        $sum = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRain")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);

        return $this->generator->generateRain( $sum->getSum() );
    }
}
