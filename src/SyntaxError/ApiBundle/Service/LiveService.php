<?php

namespace SyntaxError\ApiBundle\Service;

use Doctrine\ORM\EntityManager;

use SyntaxError\ApiBundle\Weather\Barometer;
use SyntaxError\ApiBundle\Weather\Rain;
use SyntaxError\ApiBundle\Weather\Reading;
use SyntaxError\ApiBundle\Weather\Temperature;
use SyntaxError\ApiBundle\Weather\Time;
use SyntaxError\ApiBundle\Weather\Wind;
use SyntaxError\ApiBundle\Tools\Uniter;

/**
 * Class LiveService
 * @package SyntaxError\ApiBundle\Service
 */
class LiveService
{
    /**
     * The newest Archive instance in repository.
     *
     * @var null|\SyntaxError\ApiBundle\Entity\Archive
     */
    private $lastArchive;

    /**
     * Repository of Archive. To take the last instance, search by day and calculation of trend.
     *
     * @var \SyntaxError\ApiBundle\Repository\ArchiveRepository
     */
    private $archiveRepository;

    /**
     * LiveService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->archiveRepository = $entityManager->getRepository("SyntaxErrorApiBundle:Archive");
        $this->lastArchive = $this->archiveRepository->findLast();
    }

    /**
     * Create model of last time from Weather\Time
     *
     * @return Time
     */
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

    /**
     * Create model of last humidity.
     *
     * @return Reading
     */
    public function createHumidity()
    {
        $humidity = new Reading();
        $humidity->name = "Wilgotność";
        $humidity->units = Uniter::humidity;
        $humidity->value = $this->lastArchive->getOutHumidity();
        return $humidity;
    }

    /**
     * Create model of last barometer from Weather\Barometer.
     *
     * @return Barometer
     */
    public function createBarometer()
    {
        $current = new Reading();
        $current->name = "Aktualne ciśnienie";
        $current->units = Uniter::barometer;
        $current->value = $this->lastArchive->getPressure();

        $trend = new Reading();
        $trend->name = "Tendencja ciśnienia";
        $trend->units = Uniter::barometer.Uniter::trend;
        $trend->value = $this->archiveRepository->getLastTrend('barometer');

        $pressure = new Barometer($current);
        return $pressure->setTrend($trend);
    }

    /**
     * Create model of last rain from Weather\Rain.
     *
     * @return Rain
     */
    public function createRain()
    {
        $current = new Reading();
        $current->name = "Akutalne opady";
        $current->units = Uniter::rain."/h";
        $current->value = $this->lastArchive->getRainRate();

        $sum = new Reading();
        $sum->name = "Suma opadów";
        $sum->units = Uniter::rain;
        $sum->value = $this->lastArchive->getRain();

        $rain = new Rain($current);
        return $rain->setSum($sum);
    }

    /**
     * Create model of last wind from Weather\Wind.
     *
     * @return Wind
     */
    public function createWind()
    {
        $currentSpeed = new Reading();
        $currentSpeed->name = "Aktualna prędkość";
        $currentSpeed->units = Uniter::speed;
        $currentSpeed->value = $this->lastArchive->getWindSpeed();

        $currentDir = new Reading();
        $currentDir->name = "Aktualny kierunek";
        $currentDir->units = Uniter::deg;
        $currentDir->value = $this->lastArchive->getWindDir();

        $gustSpeed = new Reading();
        $gustSpeed->name = "Prędkość porywów";
        $gustSpeed->units = Uniter::speed;
        $gustSpeed->value = $this->lastArchive->getWindGust();

        $gustDir = new Reading();
        $gustDir->name = "Kierunek porywów";
        $gustDir->units = Uniter::deg;
        $gustDir->value = $this->lastArchive->getWindGustDir();

        $wind = new Wind($currentSpeed, $currentDir);
        $wind->setTranslatedDir([
            'current' => Uniter::windDirPl($currentDir->value),
            'gust' => Uniter::windDirPl($gustDir->value)
        ]);
        return $wind->setGust($gustSpeed, $gustDir);
    }

    /**
     * Create model of last temperature from Weather\Temperature.
     *
     * @return Temperature
     */
    public function createTemperature()
    {
        $current = new Reading();
        $current->name = "Aktualna temperatura";
        $current->units = Uniter::temp;
        $current->value = $this->lastArchive->getOutTemp();


        $real = new Reading();
        $real->name = "Odczuwalna temperatura";
        $real->units = Uniter::temp;
        $real->value = Uniter::getWindChill($this->lastArchive->getWindGust(), $current->value);

        $dewPoint = new Reading();
        $dewPoint->name = "Punkt rosy";
        $dewPoint->units = Uniter::temp;
        $dewPoint->value = $this->lastArchive->getDewpoint();


        $trend = new Reading();
        $trend->name = "Tendencja temperatury";
        $trend->units = Uniter::temp.Uniter::trend;
        $trend->value = $this->archiveRepository->getLastTrend('outTemp');

        $temperature = new Temperature($current);
        $temperature->setReal($real);
        $temperature->setDewPoint($dewPoint);
        return $temperature->setTrend($trend);
    }
}
