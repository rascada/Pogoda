<?php

namespace SyntaxError\ApiBundle\Record;

use SyntaxError\ApiBundle\Interfaces\ArchiveDay;

class RecordGenerator
{
    /**
     * @param array $records
     * @param $archiveName
     * @return array
     */
    public function highGenerate(array $records, $archiveName)
    {
        $output = [];

        switch($archiveName) {
            case 'Windgustdir':
                foreach($records as $i => $record) {
                    if($record instanceof ArchiveDay) {
                        if( (new \DateTime())->setTimestamp( $record->getDatetime() )->format("H") != 0) continue;
                        $cnt = $record->getCount();
                        $output[] = [($record->getDatetime()+3600)*1000, $cnt ? $record->getSum() / $cnt : 0];
                    }
                } break;

            case 'Rain':
                foreach($records as $i => $record) {
                    if($record instanceof ArchiveDay) {
                        if( (new \DateTime())->setTimestamp( $record->getDatetime() )->format("H") != 0) continue;
                        $output[] = [($record->getDatetime()+3600)*1000, $record->getSum()];
                    }
                } break;

            default:
                foreach($records as $i => $record) {
                    if($record instanceof ArchiveDay) {
                        if( (new \DateTime())->setTimestamp( $record->getDatetime() )->format("H") != 0) continue;
                        $output[] = [($record->getDatetime()+3600)*1000, $record->getMin(), $record->getMax()];
                    }
                } break;
        }

        return $output;
    }

    /**
     * @param ArchiveDay $max
     * @param ArchiveDay $min
     * @return string|\SyntaxError\ApiBundle\Weather\MaxMin
     */
    public function generateTemperature(ArchiveDay $max, ArchiveDay $min)
    {
        if(!$max || !$min) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        $builder->set( 'min', $min->getMintime(), $min->getMin() );
        return $builder->getTemperatureRecord();
    }

    /**
     * @param ArchiveDay $max
     * @param ArchiveDay $min
     * @return string|\SyntaxError\ApiBundle\Weather\MaxMin
     */
    public function generateHumidity(ArchiveDay $max, ArchiveDay $min)
    {
        if(!$max || !$min) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        $builder->set( 'min', $min->getMintime(), $min->getMin() );
        return $builder->getHumidityRecord();
    }

    /**
     * @param ArchiveDay $max
     * @param ArchiveDay $min
     * @return string|\SyntaxError\ApiBundle\Weather\MaxMin
     */
    public function generateBarometer(ArchiveDay $max, ArchiveDay $min)
    {
        if(!$max || !$min) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        $builder->set( 'min', $min->getMintime(), $min->getMin() );
        return $builder->getBarometerRecord();
    }

    /**
     * @param ArchiveDay $max
     * @return array|string
     */
    public function generateWindSpeed(ArchiveDay $max)
    {
        if(!$max) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax() );
        return $builder->getWindSpeedRecord();
    }

    /**
     * @param ArchiveDay $max
     * @return array|string
     */
    public function generateRainRate(ArchiveDay $max)
    {
        if(!$max) return "Empty record.";
        $builder = new RecordBuilder();
        $builder->set( 'max', $max->getMaxtime(), $max->getMax());
        return $builder->getRainRateRecord();
    }

    /**
     * @param float $avg
     * @return \SyntaxError\ApiBundle\Weather\Reading
     */
    public function generateWindDir($avg)
    {
        $builder = new RecordBuilder();
        $builder->set( 'avg', "Średni kierunek wiatru", $avg);
        return $builder->getWindDirAvg();
    }

    /**
     * @param float $sum
     * @return \SyntaxError\ApiBundle\Weather\Reading
     */
    public function generateRain($sum)
    {
        $builder = new RecordBuilder();
        $builder->set( 'sum', "Suma opadów", $sum);
        return $builder->getRainRecord();
    }
}
