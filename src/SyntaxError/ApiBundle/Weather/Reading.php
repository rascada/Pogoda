<?php

namespace SyntaxError\ApiBundle\Weather;

/**
 * Class Reading
 * One reading from every sensor.
 *
 * @package SyntaxError\ApiBundle\Weather
 */
class Reading
{
    /**
     * @var string
     */
    public $name = "";

    /**
     * @var int
     */
    public $value = 0;

    /**
     * @var string
     */
    public $units = "";
}
