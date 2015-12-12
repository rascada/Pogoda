<?php

namespace SyntaxError\ApiBundle\Weather;

/**
 * Class Temperature
 * @package SyntaxError\ApiBundle\Model\Basic
 */
class Temperature
{
    /**
     * @var Reading
     */
    private $current;

    /**
     * @var Reading
     */
    private $real;

    /**
     * @var Reading
     */
    private $dewPoint;

    /**
     * @var Reading
     */
    private $trend;

    /**
     * @param $temperature
     */
    public function __construct(Reading $temperature)
    {
        $this->current = $temperature;
    }

    /**
     * @return Reading
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param Reading $current
     * @return Temperature
     */
    public function setCurrent(Reading $current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * @return Reading
     */
    public function getReal()
    {
        return $this->real;
    }

    /**
     * @param Reading $real
     * @return Temperature
     */
    public function setReal(Reading $real)
    {
        $this->real = $real;

        return $this;
    }

    /**
     * @return Reading
     */
    public function getDewPoint()
    {
        return $this->dewPoint;
    }

    /**
     * @param Reading $dewPoint
     * @return Temperature
     */
    public function setDewPoint(Reading $dewPoint)
    {
        $this->dewPoint = $dewPoint;

        return $this;
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
     * @return Temperature
     */
    public function setTrend(Reading $trend)
    {
        $this->trend = $trend;

        return $this;
    }
}
