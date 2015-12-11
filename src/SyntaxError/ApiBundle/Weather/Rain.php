<?php

namespace SyntaxError\ApiBundle\Weather;

/**
 * Class Rain
 * @package SyntaxError\ApiBundle\Model\Basic
 */
class Rain
{
    /**
     * @var Reading
     */
    private $current;

    /**
     * @var Reading
     */
    private $sum;

    public function __construct(Reading $rainRate)
    {
        $this->current = $rainRate;
    }

    /**
     * @return Reading
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param Reading $sum
     * @return Rain
     */
    public function setSum(Reading $sum)
    {
        $this->sum = $sum;

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
