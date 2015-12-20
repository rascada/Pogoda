<?php

namespace SyntaxError\ApiBundle\Interfaces;

interface ArchiveService
{
    public function highFormatter(\DateTime $datetime, $archiveName);

    public function createTemperature(\DateTime $dateTime);

    public function createHumidity(\DateTime $dateTime);

    public function createBarometer(\DateTime $dateTime);

    public function createWindSpeed(\DateTime $dateTime);

    public function createWindDir(\DateTime $dateTime);

    public function createRain(\DateTime $dateTime);

    public function createRainRate(\DateTime $dateTime);

}
