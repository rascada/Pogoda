<?php

namespace SyntaxError\ApiBundle\Tools;

use SyntaxError\ApiBundle\Weather\Reading;
use SyntaxError\ApiBundle\Weather\MaxMin;

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

    public function getTemperatureRecord()
    {
        $this->max->units = Uniter::temp;
        $this->min->units = Uniter::temp;
        return $this->createRecord();
    }

    public function getHumidityRecord()
    {
        $this->max->units = Uniter::humidity;
        $this->min->units = Uniter::humidity;
        return $this->createRecord();
    }

    public function getBarometerRecord()
    {
        $this->max->units = Uniter::barometer;
        $this->min->units = Uniter::barometer;
        return $this->createRecord();
    }

    private function createRecord()
    {
        $maxMin = new MaxMin();
        $maxMin->setMax($this->max);
        $maxMin->setMin($this->min);
        return $maxMin;
    }

}
