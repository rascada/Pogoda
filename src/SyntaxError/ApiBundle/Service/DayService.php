<?php

namespace SyntaxError\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use SyntaxError\ApiBundle\Interfaces\ArchiveService;
use SyntaxError\ApiBundle\Weather\MaxMin;
use SyntaxError\ApiBundle\Weather\Reading;

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
            $response[] = [$archive->getDateTime(), $value ? $value : 0];
        }
        return $response;
    }

    public function createTemperature(\DateTime $dateTime)
    {
        $isToday = $dateTime->format("Ymd") == (new \DateTime('now'))->format("Ymd");
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuttemp")->findOneBy([
            'datetime' => $dateTime->getTimestamp()
        ]);
        if(!$record && !$isToday) return "Empty record.";
        $max = new Reading();
        $min = new Reading();
        $max->units = "℃";
        $min->units = "℃";

        if($isToday) {
            $maxTemperature = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findTodayRecord('outTemp');
            $minTemperature = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findTodayRecord('outTemp', false);
            if($maxTemperature === null || $minTemperature === null) return "Empty record.";
            $max->name = (new \DateTime)->setTimestamp( $maxTemperature['dateTime'] )->format("Y-m-d H:i:s");
            $max->value = $maxTemperature['outTemp'];

            $min->name = (new \DateTime)->setTimestamp( $minTemperature['dateTime'] )->format("Y-m-d H:i:s");
            $min->value = $minTemperature['outTemp'];
        } else {
            $max->name = (new \DateTime)->setTimestamp( $record->getMaxtime() )->format("Y-m-d H:i:s");
            $max->value = $record->getMax();

            $min->name = (new \DateTime)->setTimestamp( $record->getMintime() )->format("Y-m-d H:i:s");
            $min->value = $record->getMin();
        }

        $temperature = new MaxMin();
        $temperature->setMax($max);
        return $temperature->setMin($min);
    }

    public function createHumidity(\DateTime $dateTime)
    {
        $isToday = $dateTime->format("Ymd") == (new \DateTime('now'))->format("Ymd");
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayOuthumidity")->findOneBy([
            'datetime' => $dateTime->getTimestamp()
        ]);
        if(!$record && !$isToday) return "Empty record.";
        $max = new Reading();
        $min = new Reading();
        $max->units = "%";
        $min->units = "%";

        if($isToday) {
            $maxHumidity = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findTodayRecord('outHumidity');
            $minHumidity = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findTodayRecord('outHumidity', false);
            if($maxHumidity === null || $minHumidity === null) return "Empty record.";
            $max->name = (new \DateTime)->setTimestamp( $maxHumidity['dateTime'] )->format("Y-m-d H:i:s");
            $max->value = $maxHumidity['outHumidity'];

            $min->name = (new \DateTime)->setTimestamp( $minHumidity['dateTime'] )->format("Y-m-d H:i:s");
            $min->value = $minHumidity['outHumidity'];
        } else {
            $max->name = (new \DateTime)->setTimestamp( $record->getMaxtime() )->format("Y-m-d H:i:s");
            $max->value = $record->getMax();

            $min->name = (new \DateTime)->setTimestamp( $record->getMintime() )->format("Y-m-d H:i:s");
            $min->value = $record->getMin();
        }

        $humidity = new MaxMin();
        $humidity->setMax($max);
        return $humidity->setMin($min);
    }

    public function createBarometer(\DateTime $dateTime)
    {
        $isToday = $dateTime->format("Ymd") == (new \DateTime('now'))->format("Ymd");
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayBarometer")->findOneBy([
            'datetime' => $dateTime->getTimestamp()
        ]);
        if(!$record && !$isToday) return "Empty record.";
        $max = new Reading();
        $min = new Reading();
        $max->units = "hPa";
        $min->units = "hPa";

        if($isToday) {
            $maxBarometer = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findTodayRecord('barometer');
            $minBarometer = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findTodayRecord('barometer', false);
            if($maxBarometer === null || $minBarometer === null) return "Empty record.";
            $max->name = (new \DateTime)->setTimestamp( $maxBarometer['dateTime'] )->format("Y-m-d H:i:s");
            $max->value = $maxBarometer['barometer'];

            $min->name = (new \DateTime)->setTimestamp( $maxBarometer['dateTime'] )->format("Y-m-d H:i:s");
            $min->value = $minBarometer['barometer'];
        } else {
            $max->name = (new \DateTime)->setTimestamp( $record->getMaxtime() )->format("Y-m-d H:i:s");
            $max->value = $record->getMax();

            $min->name = (new \DateTime)->setTimestamp( $record->getMintime() )->format("Y-m-d H:i:s");
            $min->value = $record->getMin();
        }

        $barometer = new MaxMin();
        $barometer->setMax($max);
        return $barometer->setMin($min);
    }

    public function createWindSpeed(\DateTime $dateTime)
    {
        $isToday = $dateTime->format("Ymd") == (new \DateTime('now'))->format("Ymd");
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgust")->findOneBy([
            'datetime' => $dateTime->getTimestamp()
        ]);
        if(!$record && !$isToday) return "Empty record.";

        $max = new Reading();
        $max->units = "km/h";
        if($isToday) {
            $windMax = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findTodayRecord('windGust');
            if($windMax === null) return "Empty record.";
            $max->value = $windMax['windGust'];
            $max->name = (new \DateTime())->setTimestamp( $windMax['dateTime'] )->format("Y-m-d H:i:s");
        } else {
            $max->name = (new \DateTime)->setTimestamp( $record->getMaxtime() )->format("Y-m-d H:i:s");
            $max->value = $record->getMax();
        }

        return ['max' => $max];
    }

    public function createWindDir(\DateTime $dateTime)
    {
        $isToday = $dateTime->format("Ymd") == (new \DateTime('now'))->format("Ymd");
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgustdir")->findOneBy([
            'datetime' => $dateTime->getTimestamp()
        ]);
        if(!$record && !$isToday) return "Empty record.";

        $dir = new Reading();
        $dir->name = "Średni kierunek wiatru";
        $dir->units = "deg";
        if($isToday) {
            $windAvg = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findAvgWindToday();
            if($windAvg === null) return "Empty record.";
            $dir->value = $windAvg;
        } else {
            $dir->value = $record->getSum() / $record->getCount();
        }

        return $dir;
    }

    public function createRainRate(\DateTime $dateTime)
    {
        $isToday = $dateTime->format("Ymd") == (new \DateTime('now'))->format("Ymd");
        $record = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRainrate")->findOneBy([
            'datetime' => $dateTime->getTimestamp()
        ]);
        if(!$record && !$isToday) return "Empty record.";

        $max = new Reading();
        $max->units = "mm/h";
        if($isToday) {
            $rainMax = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findTodayRecord('rainRate');
            if($rainMax === null) return "Empty record.";
            $max->value = $rainMax['rainRate'];
            $max->name = (new \DateTime())->setTimestamp( $rainMax['dateTime'] )->format("Y-m-d H:i:s");
        } else {
            $max->name = (new \DateTime)->setTimestamp( $record->getMaxtime() )->format("Y-m-d H:i:s");
            $max->value = $record->getMax();
        }

        return [ 'max' => $max ];
    }

    public function createRain(\DateTime $dateTime)
    {
        $sum = $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRain")->findOneBy([
            'datetime' => $dateTime->setTime(0,0,0)->getTimestamp()
        ]);

        $reading = new Reading();
        $reading->name = "Suma opadów";
        $reading->value = $sum->getSum();
        $reading->units = "mm";
        return $reading;
    }
}
