<?php

namespace SyntaxError\ApiBundle\Record;

use SyntaxError\ApiBundle\Weather\Reading;
use SyntaxError\ApiBundle\Weather\MaxMin;
use SyntaxError\ApiBundle\Tools\Uniter;

class RecordBuilder
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
     * @var Reading
     */
    private $other;

    /**
     * RecordBuilder constructor.
     */
    public function __construct()
    {
        $this->max = new Reading();
        $this->min = new Reading();
        $this->other = new Reading();
    }

    /**
     * @param $property
     * @param $name
     * @param $value
     * @return RecordBuilder
     */
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

    /**
     * @return MaxMin
     */
    public function getTemperatureRecord()
    {
        $this->max->units = Uniter::temp;
        $this->min->units = Uniter::temp;
        return $this->createRecord();
    }

    /**
     * @return MaxMin
     */
    public function getHumidityRecord()
    {
        $this->max->units = Uniter::humidity;
        $this->min->units = Uniter::humidity;
        return $this->createRecord();
    }

    /**
     * @return MaxMin
     */
    public function getBarometerRecord()
    {
        $this->max->units = Uniter::barometer;
        $this->min->units = Uniter::barometer;
        return $this->createRecord();
    }

    /**
     * @return MaxMin
     */
    private function createRecord()
    {
        $maxMin = new MaxMin();
        $maxMin->setMax($this->max);
        $maxMin->setMin($this->min);
        return $maxMin;
    }

    /**
     * @return array
     */
    public function getWindSpeedRecord()
    {
        $this->max->units = Uniter::speed;
        return ['max' => $this->max];
    }

    /**
     * @return Reading
     */
    public function getWindDirAvg()
    {
        $this->other->units = Uniter::deg;
        return $this->other;
    }

    /**
     * @return array
     */
    public function getRainRateRecord()
    {
        $this->max->units = Uniter::rain."/h";
        return ['max' => $this->max];
    }

    /**
     * @return Reading
     */
    public function getRainRecord()
    {
        $this->other->units = Uniter::rain;
        return $this->other;
    }
}
