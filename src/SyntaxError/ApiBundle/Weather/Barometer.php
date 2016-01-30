<?php

namespace SyntaxError\ApiBundle\Weather;

/**
 * Class Barometer
 * @package SyntaxError\ApiBundle\Model\Basic
 */
class Barometer
{
    /**
     * @var Reading
     */
    private $current;

    /**
     * @var Reading
     */
    private $trend;

    public function __construct(Reading $pressure)
    {
        $this->current = $pressure;
    }

    /**
     * @return Reading
     */
    public function getTrend()
    {
        return $this->trend;
    }

    /**
     * @param Reading $trend
     * @return Barometer
     */
    public function setTrend(Reading $trend)
    {
        $this->trend = $trend;

        return $this;
    }

    /**
     * @return Reading
     */
    public function getCurrent()
    {
        return $this->current;
    }
}
