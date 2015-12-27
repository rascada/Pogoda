<?php

namespace SyntaxError\ApiBundle\Tools;

use SyntaxError\ApiBundle\Weather\Reading;
use SyntaxError\ApiBundle\Weather\MaxMin;

class RecordBuilder
{
    private $max;

    private $min;

    private $other;

    public function __construct()
    {
        $this->max = new Reading();
        $this->min = new Reading();
        $this->other = new Reading();
    }

    public function set($property, $name, $value)
    {
        if( is_numeric($name) ) {
            $name = (new \DateTime)->setTimestamp($name)->format("Y-m-d H:i:s");
        }
        if( !property_exists($this, $property) ) {
            $this->other->name = $name;
            $this->other->value = $value;
        } else {
            $this->{$property}->name = $name;
            $this->{$property}->value = $value;
        }

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

    public function getWindSpeedRecord()
    {
        $this->max->units = Uniter::speed;
        return ['max' => $this->max];
    }

    public function getWindDirAvg()
    {
        $this->other->units = Uniter::deg;
        return $this->other;
    }

    public function getRainRateRecord()
    {
        $this->max->units = Uniter::rain."/h";
        return ['max' => $this->max];
    }

    public function getRainRecord()
    {
        $this->other->units = Uniter::rain;
        return $this->other;
    }
}
