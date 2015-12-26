<?php

namespace SyntaxError\ApiBundle\Tools;

use SyntaxError\ApiBundle\Weather\Reading;

class RecordBuilder
{
    private $max;

    private $min;

    private $avg;

    private $sum;

    public function __construct()
    {
        $this->max = new Reading();
        $this->min = new Reading();
        $this->avg = new Reading();
        $this->sum = new Reading();
    }

    public function set($property, $name, $value)
    {
        if( is_numeric($name) ) {
            $name = (new \DateTime)->setTimestamp($name)->format("Y-m-d H:i:s");
        }
        $this->{$property}->name = $name;
        $this->{$property}->value = $value;
        return $this;
    }
}
