<?php
/**
 * Created by PhpStorm.
 * User: marcin
 * Date: 28.11.15
 * Time: 18:50
 */

namespace SyntaxError\ApiBundle\Service;

use Doctrine\ORM\EntityManager;

use SyntaxError\ApiBundle\Weather\Pressure;
use SyntaxError\ApiBundle\Weather\Rain;
use SyntaxError\ApiBundle\Weather\Reading;
use SyntaxError\ApiBundle\Weather\Temperature;
use SyntaxError\ApiBundle\Weather\Time;
use SyntaxError\ApiBundle\Weather\Wind;
use SyntaxError\ApiBundle\Tools\Uniter;


class LiveService
{
    private $lastArchive;

    private $archiveRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->archiveRepository = $entityManager->getRepository("SyntaxErrorApiBundle:Archive");
        $this->lastArchive = $this->archiveRepository->findLast();
    }

    public function createTime()
    {
        $now = (new \DateTime('now'))->getTimestamp();
        $last = $this->lastArchive->getDateTime();
        $next = new Reading();
        $next->name = "Następna aktualizacja";
        $next->units = "s";
        $next->value = ($last + $this->lastArchive->getinterval()*60) - $now + 40;
        if($next->value < 0) {
            $next->value = "Offline";
        }

        $data = new Reading();
        $data->name = "Czas aktualizacji serwera";
        unset($data->units);
        $data->value = (new \DateTime())->setTimestamp($last)->format("Y-m-d H:i:s");

        $time = new Time($data);
        return $time->setNext($next);
    }

    public function createHumidity()
    {
        $humidity = new Reading();
        $humidity->name = "Wilgotność";
        $humidity->units = "%";
        $humidity->value = $this->lastArchive->getOutHumidity();
        return $humidity;
    }

    public function createBarometer()
    {
        $current = new Reading();
        $current->name = "Aktualne ciśnienie";
        $current->units = "hPa";
        $current->value = $this->lastArchive->getPressure();

        $trend = new Reading();
        $trend->name = "Tendencja ciśnienia";
        $trend->units = "hPa";
        $trend->value = $this->archiveRepository->getLastPressTrend();

        $pressure = new Pressure($current);
        return $pressure->setTrend($trend);
    }

    public function createRain()
    {
        $current = new Reading();
        $current->name = "Akutalne opady";
        $current->units = "mm/h";
        $current->value = $this->lastArchive->getRainRate();

        $sum = new Reading();
        $sum->name = "Suma opadów";
        $sum->units = "mm";
        $sum->value = $this->lastArchive->getRain();

        $rain = new Rain($current);
        return $rain->setSum($sum);
    }

    public function createWind()
    {
        $currentSpeed = new Reading();
        $currentSpeed->name = "Aktualna prędkość";
        $currentSpeed->units = "km/h";
        $currentSpeed->value = $this->lastArchive->getWindSpeed();

        $currentDir = new Reading();
        $currentDir->name = "Aktualny kierunek";
        $currentDir->units = "deg";
        $currentDir->value = $this->lastArchive->getWindDir();

        $gustSpeed = new Reading();
        $gustSpeed->name = "Prędkość porywów";
        $gustSpeed->units = "km/h";
        $gustSpeed->value = $this->lastArchive->getWindGust();

        $gustDir = new Reading();
        $gustDir->name = "Kierunek porywów";
        $gustDir->units = "deg";
        $gustDir->value = $this->lastArchive->getWindGustDir();

        $wind = new Wind($currentSpeed, $currentDir);
        return $wind->setGust($gustSpeed, $gustDir);
    }

    public function createTemperature()
    {
        $current = new Reading();
        $current->name = "Aktualna temperatura";
        $current->units = "℃";
        $current->value = $this->lastArchive->getOutTemp();


        $real = new Reading();
        $real->name = "Odczuwalna temperatura";
        $real->units = "℃";
        $real->value = Uniter::getWindChill($this->lastArchive->getWindGust(), $current->value);

        $dewPoint = new Reading();
        $dewPoint->name = "Punkt rosy";
        $dewPoint->units = "℃";
        $dewPoint->value = $this->lastArchive->getDewpoint();


        $trend = new Reading();
        $trend->name = "Tendencja temperatury";
        $trend->units = "℃/h";
        $trend->value = $this->archiveRepository->getLastTempTrend();

        $temperature = new Temperature($current);
        $temperature->setReal($real);
        $temperature->setDewPoint($dewPoint);
        return $temperature->setTrend($trend);
    }
}
