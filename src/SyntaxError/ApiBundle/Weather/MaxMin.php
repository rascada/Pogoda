<?php

namespace SyntaxError\ApiBundle\Weather;

/**
 * Class MaxMin
 * Model for record generation.
 *
 * @package SyntaxError\ApiBundle\Weather
 */
class MaxMin
{
    /**
     * @var Reading
     */
    private $max;

    /**
     * @var Reading
     */
    private $min;

    /**
     * @return Reading
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param Reading $max
     * @return MaxMin
     */
    public function setMax(Reading $max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return Reading
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param Reading $min
     * @return MaxMin
     */
    public function setMin(Reading $min)
    {
        $this->min = $min;

        return $this;
    }
}
