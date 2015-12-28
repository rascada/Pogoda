<?php

namespace SyntaxError\ApiBundle\Service\Archive;

use Doctrine\ORM\EntityManager;
use SyntaxError\ApiBundle\Entity\ArchiveDayOuttemp;
use SyntaxError\ApiBundle\Entity\ArchiveDayWindgustdir;
use SyntaxError\ApiBundle\Interfaces\ArchiveService;
use SyntaxError\ApiBundle\Record\RecordGenerator;
use SyntaxError\ApiBundle\Repository\ArchiveDayRepository;

class MonthService implements ArchiveService
{
    private $em;

    private $generator;

    public function __construct(EntityManager $entityManager)
    {
        $this->generator = new RecordGenerator();
        $this->em = $entityManager;
    }

    public function highFormatter(\DateTime $dateTime, $archiveName)
    {
        $from = (new \DateTime( $dateTime->format("Y-m-01 00:00:00") ));
        $to = (new \DateTime( $dateTime->format("Y-m-t 23:59:59") ));

        $repository = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDay$archiveName");
        if($repository instanceof ArchiveDayRepository) {
            $records = $repository->findBetween($from, $to);
            return $this->generator->highGenerate($records, $archiveName);
        }
        return null;
    }

    public function createTemperature(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuttemp")->findMonthRecord($dateTime);
        $min = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuttemp")->findMonthRecord($dateTime, false);

        return $this->generator->generateTemperature($max, $min);
    }

    public function createHumidity(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuthumidity")->findMonthRecord($dateTime);
        $min = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuthumidity")->findMonthRecord($dateTime, false);

        return $this->generator->generateHumidity($max, $min);
    }

    public function createBarometer(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayBarometer")->findMonthRecord($dateTime);
        $min = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayBarometer")->findMonthRecord($dateTime, false);

        return $this->generator->generateBarometer($max, $min);
    }

    public function createWindSpeed(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgust")->findMonthRecord($dateTime);

        return $this->generator->generateWindSpeed($max);
    }

    public function createWindDir(\DateTime $dateTime)
    {
        $avg = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgustdir")->avgMonth($dateTime);

        return $this->generator->generateWindDir($avg);
    }

    public function createRain(\DateTime $dateTime)
    {
        $sum = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRain")->findMonthSum($dateTime);

        return $this->generator->generateRain($sum);
    }

    public function createRainRate(\DateTime $dateTime)
    {
        $max = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRainrate")->findMonthRecord($dateTime);

        return $this->generator->generateRainRate($max);
    }

}
