<?php

namespace SyntaxError\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * archive
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="SyntaxError\ApiBundle\Repository\ArchiveRepository")
 */
class Archive
{

    /**
     * @var integer
     *
     * @ORM\Column(name="dateTime", type="integer")
     * @ORM\Id
     */
    private $dateTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="usUnits", type="integer")
     */
    private $usUnits;

    /**
     * @var integer
     *
     * @ORM\Column(name="interval", type="integer")
     */
    private $interval;

    /**
     * @var float
     *
     * @ORM\Column(name="barometer", type="float", nullable=true)
     */
    private $barometer;

    /**
     * @var float
     *
     * @ORM\Column(name="pressure", type="float", nullable=true)
     */
    private $pressure;

    /**
     * @var float
     *
     * @ORM\Column(name="altimeter", type="float", nullable=true)
     */
    private $altimeter;

    /**
     * @var float
     *
     * @ORM\Column(name="inTemp", type="float", nullable=true)
     */
    private $inTemp;

    /**
     * @var float
     *
     * @ORM\Column(name="outTemp", type="float", nullable=true)
     */
    private $outTemp;

    /**
     * @var float
     *
     * @ORM\Column(name="inHumidity", type="float", nullable=true)
     */
    private $inHumidity;

    /**
     * @var float
     *
     * @ORM\Column(name="outHumidity", type="float", nullable=true)
     */
    private $outHumidity;

    /**
     * @var float
     *
     * @ORM\Column(name="windSpeed", type="float", nullable=true)
     */
    private $windSpeed;

    /**
     * @var float
     *
     * @ORM\Column(name="windDir", type="float", nullable=true)
     */
    private $windDir;

    /**
     * @var float
     *
     * @ORM\Column(name="windGust", type="float", nullable=true)
     */
    private $windGust;

    /**
     * @var float
     *
     * @ORM\Column(name="windGustDir", type="float", nullable=true)
     */
    private $windGustDir;

    /**
     * @var float
     *
     * @ORM\Column(name="rainRate", type="float", nullable=true)
     */
    private $rainRate;

    /**
     * @var float
     *
     * @ORM\Column(name="rain", type="float", nullable=true)
     */
    private $rain;

    /**
     * @var float
     *
     * @ORM\Column(name="dewpoint", type="float", nullable=true)
     */
    private $dewpoint;

    /**
     * @var float
     *
     * @ORM\Column(name="windchill", type="float", nullable=true)
     */
    private $windchill;

    /**
     * @var float
     *
     * @ORM\Column(name="heatindex", type="float", nullable=true)
     */
    private $heatindex;

    /**
     * @var float
     *
     * @ORM\Column(name="ET", type="float", nullable=true)
     */
    private $eT;

    /**
     * @var float
     *
     * @ORM\Column(name="radiation", type="float", nullable=true)
     */
    private $radiation;

    /**
     * @var float
     *
     * @ORM\Column(name="UV", type="float", nullable=true)
     */
    private $uV;

    /**
     * @var float
     *
     * @ORM\Column(name="extraTemp1", type="float", nullable=true)
     */
    private $extraTemp1;

    /**
     * @var float
     *
     * @ORM\Column(name="extraTemp2", type="float", nullable=true)
     */
    private $extraTemp2;

    /**
     * @var float
     *
     * @ORM\Column(name="extraTemp3", type="float", nullable=true)
     */
    private $extraTemp3;

    /**
     * @var float
     *
     * @ORM\Column(name="soilTemp1", type="float", nullable=true)
     */
    private $soilTemp1;

    /**
     * @var float
     *
     * @ORM\Column(name="soilTemp2", type="float", nullable=true)
     */
    private $soilTemp2;

    /**
     * @var float
     *
     * @ORM\Column(name="soilTemp3", type="float", nullable=true)
     */
    private $soilTemp3;

    /**
     * @var float
     *
     * @ORM\Column(name="soilTemp4", type="float", nullable=true)
     */
    private $soilTemp4;

    /**
     * @var float
     *
     * @ORM\Column(name="leafTemp1", type="float", nullable=true)
     */
    private $leafTemp1;

    /**
     * @var float
     *
     * @ORM\Column(name="leafTemp2", type="float", nullable=true)
     */
    private $leafTemp2;

    /**
     * @var float
     *
     * @ORM\Column(name="extraHumid1", type="float", nullable=true)
     */
    private $extraHumid1;

    /**
     * @var float
     *
     * @ORM\Column(name="extraHumid2", type="float", nullable=true)
     */
    private $extraHumid2;

    /**
     * @var float
     *
     * @ORM\Column(name="soilMoist1", type="float", nullable=true)
     */
    private $soilMoist1;

    /**
     * @var float
     *
     * @ORM\Column(name="soilMoist2", type="float", nullable=true)
     */
    private $soilMoist2;

    /**
     * @var float
     *
     * @ORM\Column(name="soilMoist3", type="float", nullable=true)
     */
    private $soilMoist3;

    /**
     * @var float
     *
     * @ORM\Column(name="soilMoist4", type="float", nullable=true)
     */
    private $soilMoist4;

    /**
     * @var float
     *
     * @ORM\Column(name="leafWet1", type="float", nullable=true)
     */
    private $leafWet1;

    /**
     * @var float
     *
     * @ORM\Column(name="leafWet2", type="float", nullable=true)
     */
    private $leafWet2;

    /**
     * @var float
     *
     * @ORM\Column(name="rxCheckPercent", type="float", nullable=true)
     */
    private $rxCheckPercent;

    /**
     * @var float
     *
     * @ORM\Column(name="txBatteryStatus", type="float", nullable=true)
     */
    private $txBatteryStatus;

    /**
     * @var float
     *
     * @ORM\Column(name="consBatteryVoltage", type="float", nullable=true)
     */
    private $consBatteryVoltage;

    /**
     * @var float
     *
     * @ORM\Column(name="hail", type="float", nullable=true)
     */
    private $hail;

    /**
     * @var float
     *
     * @ORM\Column(name="hailRate", type="float", nullable=true)
     */
    private $hailRate;

    /**
     * @var float
     *
     * @ORM\Column(name="heatingTemp", type="float", nullable=true)
     */
    private $heatingTemp;

    /**
     * @var float
     *
     * @ORM\Column(name="heatingVoltage", type="float", nullable=true)
     */
    private $heatingVoltage;

    /**
     * @var float
     *
     * @ORM\Column(name="supplyVoltage", type="float", nullable=true)
     */
    private $supplyVoltage;

    /**
     * @var float
     *
     * @ORM\Column(name="referenceVoltage", type="float", nullable=true)
     */
    private $referenceVoltage;

    /**
     * @var float
     *
     * @ORM\Column(name="windBatteryStatus", type="float", nullable=true)
     */
    private $windBatteryStatus;

    /**
     * @var float
     *
     * @ORM\Column(name="rainBatteryStatus", type="float", nullable=true)
     */
    private $rainBatteryStatus;

    /**
     * @var float
     *
     * @ORM\Column(name="outTempBatteryStatus", type="float", nullable=true)
     */
    private $outTempBatteryStatus;

    /**
     * @var float
     *
     * @ORM\Column(name="inTempBatteryStatus", type="float", nullable=true)
     */
    private $inTempBatteryStatus;


    /**
     * @return float
     */
    public function getRainBatteryStatus()
    {
        return $this->rainBatteryStatus;
    }

    /**
     * @param float $rainBatteryStatus
     * @return float
     */
    public function setRainBatteryStatus($rainBatteryStatus)
    {
        $this->rainBatteryStatus = $rainBatteryStatus;
        return $this->rainBatteryStatus;
    }

    /**
     * Set dateTime
     *
     * @param integer $dateTime
     * @return archive
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get dateTime
     *
     * @return integer 
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Set usUnits
     *
     * @param integer $usUnits
     * @return archive
     */
    public function setUsUnits($usUnits)
    {
        $this->usUnits = $usUnits;

        return $this;
    }

    /**
     * Get usUnits
     *
     * @return integer 
     */
    public function getUsUnits()
    {
        return $this->usUnits;
    }

    /**
     * Set interval
     *
     * @param integer $interval
     * @return archive
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
        return $this;
    }

    /**
     * Get interval
     *
     * @return integer 
     */
    public function getinterval()
    {
        return $this->interval;
    }

    /**
     * Set barometer
     *
     * @param float $barometer
     * @return archive
     */
    public function setBarometer($barometer)
    {
        $this->barometer = $barometer;

        return $this;
    }

    /**
     * Get barometer
     *
     * @return float 
     */
    public function getBarometer()
    {
        return $this->barometer;
    }

    /**
     * Set pressure
     *
     * @param float $pressure
     * @return archive
     */
    public function setPressure($pressure)
    {
        $this->pressure = $pressure;

        return $this;
    }

    /**
     * Get pressure
     *
     * @return float 
     */
    public function getPressure()
    {
        return $this->pressure;
    }

    /**
     * Set altimeter
     *
     * @param float $altimeter
     * @return archive
     */
    public function setAltimeter($altimeter)
    {
        $this->altimeter = $altimeter;

        return $this;
    }

    /**
     * Get altimeter
     *
     * @return float 
     */
    public function getAltimeter()
    {
        return $this->altimeter;
    }

    /**
     * Set inTemp
     *
     * @param float $inTemp
     * @return archive
     */
    public function setInTemp($inTemp)
    {
        $this->inTemp = $inTemp;

        return $this;
    }

    /**
     * Get inTemp
     *
     * @return float 
     */
    public function getInTemp()
    {
        return $this->inTemp;
    }

    /**
     * Set outTemp
     *
     * @param float $outTemp
     * @return archive
     */
    public function setOutTemp($outTemp)
    {
        $this->outTemp = $outTemp;

        return $this;
    }

    /**
     * Get outTemp
     *
     * @return float 
     */
    public function getOutTemp()
    {
        return $this->outTemp;
    }

    /**
     * Set inHumidity
     *
     * @param float $inHumidity
     * @return archive
     */
    public function setInHumidity($inHumidity)
    {
        $this->inHumidity = $inHumidity;

        return $this;
    }

    /**
     * Get inHumidity
     *
     * @return float 
     */
    public function getInHumidity()
    {
        return $this->inHumidity;
    }

    /**
     * Set outHumidity
     *
     * @param float $outHumidity
     * @return archive
     */
    public function setOutHumidity($outHumidity)
    {
        $this->outHumidity = $outHumidity;

        return $this;
    }

    /**
     * Get outHumidity
     *
     * @return float 
     */
    public function getOutHumidity()
    {
        return $this->outHumidity;
    }

    /**
     * Set windSpeed
     *
     * @param float $windSpeed
     * @return archive
     */
    public function setWindSpeed($windSpeed)
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    /**
     * Get windSpeed
     *
     * @return float 
     */
    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    /**
     * Set windDir
     *
     * @param float $windDir
     * @return archive
     */
    public function setWindDir($windDir)
    {
        $this->windDir = $windDir;

        return $this;
    }

    /**
     * Get windDir
     *
     * @return float 
     */
    public function getWindDir()
    {
        return $this->windDir;
    }

    /**
     * Set windGust
     *
     * @param float $windGust
     * @return archive
     */
    public function setWindGust($windGust)
    {
        $this->windGust = $windGust;

        return $this;
    }

    /**
     * Get windGust
     *
     * @return float 
     */
    public function getWindGust()
    {
        return $this->windGust;
    }

    /**
     * Set windGustDir
     *
     * @param float $windGustDir
     * @return archive
     */
    public function setWindGustDir($windGustDir)
    {
        $this->windGustDir = $windGustDir;

        return $this;
    }

    /**
     * Get windGustDir
     *
     * @return float 
     */
    public function getWindGustDir()
    {
        return $this->windGustDir;
    }

    /**
     * Set rainRate
     *
     * @param float $rainRate
     * @return archive
     */
    public function setRainRate($rainRate)
    {
        $this->rainRate = $rainRate;

        return $this;
    }

    /**
     * Get rainRate
     *
     * @return float 
     */
    public function getRainRate()
    {
        return $this->rainRate*25.4;
    }

    /**
     * Set rain
     *
     * @param float $rain
     * @return archive
     */
    public function setRain($rain)
    {
        $this->rain = $rain;

        return $this;
    }

    /**
     * Get rain
     *
     * @return float 
     */
    public function getRain()
    {
        return $this->rain*25.4;
    }

    /**
     * Set dewpoint
     *
     * @param float $dewpoint
     * @return archive
     */
    public function setDewpoint($dewpoint)
    {
        $this->dewpoint = $dewpoint;

        return $this;
    }

    /**
     * Get dewpoint
     *
     * @return float 
     */
    public function getDewpoint()
    {
        return $this->dewpoint;
    }

    /**
     * Set windchill
     *
     * @param float $windchill
     * @return archive
     */
    public function setWindchill($windchill)
    {
        $this->windchill = $windchill;

        return $this;
    }

    /**
     * Get windchill
     *
     * @return float 
     */
    public function getWindchill()
    {
        return $this->windchill;
    }

    /**
     * Set heatindex
     *
     * @param float $heatindex
     * @return archive
     */
    public function setHeatindex($heatindex)
    {
        $this->heatindex = $heatindex;

        return $this;
    }

    /**
     * Get heatindex
     *
     * @return float 
     */
    public function getHeatindex()
    {
        return $this->heatindex;
    }

    /**
     * Set eT
     *
     * @param float $eT
     * @return archive
     */
    public function setET($eT)
    {
        $this->eT = $eT;

        return $this;
    }

    /**
     * Get eT
     *
     * @return float 
     */
    public function getET()
    {
        return $this->eT;
    }

    /**
     * Set radiation
     *
     * @param float $radiation
     * @return archive
     */
    public function setRadiation($radiation)
    {
        $this->radiation = $radiation;

        return $this;
    }

    /**
     * Get radiation
     *
     * @return float 
     */
    public function getRadiation()
    {
        return $this->radiation;
    }

    /**
     * Set uV
     *
     * @param float $uV
     * @return archive
     */
    public function setUV($uV)
    {
        $this->uV = $uV;

        return $this;
    }

    /**
     * Get uV
     *
     * @return float 
     */
    public function getUV()
    {
        return $this->uV;
    }

    /**
     * Set extraTemp1
     *
     * @param float $extraTemp1
     * @return archive
     */
    public function setExtraTemp1($extraTemp1)
    {
        $this->extraTemp1 = $extraTemp1;

        return $this;
    }

    /**
     * Get extraTemp1
     *
     * @return float 
     */
    public function getExtraTemp1()
    {
        return $this->extraTemp1;
    }

    /**
     * Set extraTemp2
     *
     * @param float $extraTemp2
     * @return archive
     */
    public function setExtraTemp2($extraTemp2)
    {
        $this->extraTemp2 = $extraTemp2;

        return $this;
    }

    /**
     * Get extraTemp2
     *
     * @return float 
     */
    public function getExtraTemp2()
    {
        return $this->extraTemp2;
    }

    /**
     * Set extraTemp3
     *
     * @param float $extraTemp3
     * @return archive
     */
    public function setExtraTemp3($extraTemp3)
    {
        $this->extraTemp3 = $extraTemp3;

        return $this;
    }

    /**
     * Get extraTemp3
     *
     * @return float 
     */
    public function getExtraTemp3()
    {
        return $this->extraTemp3;
    }

    /**
     * Set soilTemp1
     *
     * @param float $soilTemp1
     * @return archive
     */
    public function setSoilTemp1($soilTemp1)
    {
        $this->soilTemp1 = $soilTemp1;

        return $this;
    }

    /**
     * Get soilTemp1
     *
     * @return float 
     */
    public function getSoilTemp1()
    {
        return $this->soilTemp1;
    }

    /**
     * Set soilTemp2
     *
     * @param float $soilTemp2
     * @return archive
     */
    public function setSoilTemp2($soilTemp2)
    {
        $this->soilTemp2 = $soilTemp2;

        return $this;
    }

    /**
     * Get soilTemp2
     *
     * @return float 
     */
    public function getSoilTemp2()
    {
        return $this->soilTemp2;
    }

    /**
     * Set soilTemp3
     *
     * @param float $soilTemp3
     * @return archive
     */
    public function setSoilTemp3($soilTemp3)
    {
        $this->soilTemp3 = $soilTemp3;

        return $this;
    }

    /**
     * Get soilTemp3
     *
     * @return float 
     */
    public function getSoilTemp3()
    {
        return $this->soilTemp3;
    }

    /**
     * Set soilTemp4
     *
     * @param float $soilTemp4
     * @return archive
     */
    public function setSoilTemp4($soilTemp4)
    {
        $this->soilTemp4 = $soilTemp4;

        return $this;
    }

    /**
     * Get soilTemp4
     *
     * @return float 
     */
    public function getSoilTemp4()
    {
        return $this->soilTemp4;
    }

    /**
     * Set leafTemp1
     *
     * @param float $leafTemp1
     * @return archive
     */
    public function setLeafTemp1($leafTemp1)
    {
        $this->leafTemp1 = $leafTemp1;

        return $this;
    }

    /**
     * Get leafTemp1
     *
     * @return float 
     */
    public function getLeafTemp1()
    {
        return $this->leafTemp1;
    }

    /**
     * Set leafTemp2
     *
     * @param float $leafTemp2
     * @return archive
     */
    public function setLeafTemp2($leafTemp2)
    {
        $this->leafTemp2 = $leafTemp2;

        return $this;
    }

    /**
     * Get leafTemp2
     *
     * @return float 
     */
    public function getLeafTemp2()
    {
        return $this->leafTemp2;
    }

    /**
     * Set extraHumid1
     *
     * @param float $extraHumid1
     * @return archive
     */
    public function setExtraHumid1($extraHumid1)
    {
        $this->extraHumid1 = $extraHumid1;

        return $this;
    }

    /**
     * Get extraHumid1
     *
     * @return float 
     */
    public function getExtraHumid1()
    {
        return $this->extraHumid1;
    }

    /**
     * Set extraHumid2
     *
     * @param float $extraHumid2
     * @return archive
     */
    public function setExtraHumid2($extraHumid2)
    {
        $this->extraHumid2 = $extraHumid2;

        return $this;
    }

    /**
     * Get extraHumid2
     *
     * @return float 
     */
    public function getExtraHumid2()
    {
        return $this->extraHumid2;
    }

    /**
     * Set soilMoist1
     *
     * @param float $soilMoist1
     * @return archive
     */
    public function setSoilMoist1($soilMoist1)
    {
        $this->soilMoist1 = $soilMoist1;

        return $this;
    }

    /**
     * Get soilMoist1
     *
     * @return float 
     */
    public function getSoilMoist1()
    {
        return $this->soilMoist1;
    }

    /**
     * Set soilMoist2
     *
     * @param float $soilMoist2
     * @return archive
     */
    public function setSoilMoist2($soilMoist2)
    {
        $this->soilMoist2 = $soilMoist2;

        return $this;
    }

    /**
     * Get soilMoist2
     *
     * @return float 
     */
    public function getSoilMoist2()
    {
        return $this->soilMoist2;
    }

    /**
     * Set soilMoist3
     *
     * @param float $soilMoist3
     * @return archive
     */
    public function setSoilMoist3($soilMoist3)
    {
        $this->soilMoist3 = $soilMoist3;

        return $this;
    }

    /**
     * Get soilMoist3
     *
     * @return float 
     */
    public function getSoilMoist3()
    {
        return $this->soilMoist3;
    }

    /**
     * Set soilMoist4
     *
     * @param float $soilMoist4
     * @return archive
     */
    public function setSoilMoist4($soilMoist4)
    {
        $this->soilMoist4 = $soilMoist4;

        return $this;
    }

    /**
     * Get soilMoist4
     *
     * @return float 
     */
    public function getSoilMoist4()
    {
        return $this->soilMoist4;
    }

    /**
     * Set leafWet1
     *
     * @param float $leafWet1
     * @return archive
     */
    public function setLeafWet1($leafWet1)
    {
        $this->leafWet1 = $leafWet1;

        return $this;
    }

    /**
     * Get leafWet1
     *
     * @return float 
     */
    public function getLeafWet1()
    {
        return $this->leafWet1;
    }

    /**
     * Set leafWet2
     *
     * @param float $leafWet2
     * @return archive
     */
    public function setLeafWet2($leafWet2)
    {
        $this->leafWet2 = $leafWet2;

        return $this;
    }

    /**
     * Get leafWet2
     *
     * @return float 
     */
    public function getLeafWet2()
    {
        return $this->leafWet2;
    }

    /**
     * Set rxCheckPercent
     *
     * @param float $rxCheckPercent
     * @return archive
     */
    public function setRxCheckPercent($rxCheckPercent)
    {
        $this->rxCheckPercent = $rxCheckPercent;

        return $this;
    }

    /**
     * Get rxCheckPercent
     *
     * @return float 
     */
    public function getRxCheckPercent()
    {
        return $this->rxCheckPercent;
    }

    /**
     * Set txBatteryStatus
     *
     * @param float $txBatteryStatus
     * @return archive
     */
    public function setTxBatteryStatus($txBatteryStatus)
    {
        $this->txBatteryStatus = $txBatteryStatus;

        return $this;
    }

    /**
     * Get txBatteryStatus
     *
     * @return float 
     */
    public function getTxBatteryStatus()
    {
        return $this->txBatteryStatus;
    }

    /**
     * Set consBatteryVoltage
     *
     * @param float $consBatteryVoltage
     * @return archive
     */
    public function setConsBatteryVoltage($consBatteryVoltage)
    {
        $this->consBatteryVoltage = $consBatteryVoltage;

        return $this;
    }

    /**
     * Get consBatteryVoltage
     *
     * @return float 
     */
    public function getConsBatteryVoltage()
    {
        return $this->consBatteryVoltage;
    }

    /**
     * Set hail
     *
     * @param float $hail
     * @return archive
     */
    public function setHail($hail)
    {
        $this->hail = $hail;

        return $this;
    }

    /**
     * Get hail
     *
     * @return float 
     */
    public function getHail()
    {
        return $this->hail;
    }

    /**
     * Set hailRate
     *
     * @param float $hailRate
     * @return archive
     */
    public function setHailRate($hailRate)
    {
        $this->hailRate = $hailRate;

        return $this;
    }

    /**
     * Get hailRate
     *
     * @return float 
     */
    public function getHailRate()
    {
        return $this->hailRate;
    }

    /**
     * Set heatingTemp
     *
     * @param float $heatingTemp
     * @return archive
     */
    public function setHeatingTemp($heatingTemp)
    {
        $this->heatingTemp = $heatingTemp;

        return $this;
    }

    /**
     * Get heatingTemp
     *
     * @return float 
     */
    public function getHeatingTemp()
    {
        return $this->heatingTemp;
    }

    /**
     * Set heatingVoltage
     *
     * @param float $heatingVoltage
     * @return archive
     */
    public function setHeatingVoltage($heatingVoltage)
    {
        $this->heatingVoltage = $heatingVoltage;

        return $this;
    }

    /**
     * Get heatingVoltage
     *
     * @return float 
     */
    public function getHeatingVoltage()
    {
        return $this->heatingVoltage;
    }

    /**
     * Set supplyVoltage
     *
     * @param float $supplyVoltage
     * @return archive
     */
    public function setSupplyVoltage($supplyVoltage)
    {
        $this->supplyVoltage = $supplyVoltage;

        return $this;
    }

    /**
     * Get supplyVoltage
     *
     * @return float 
     */
    public function getSupplyVoltage()
    {
        return $this->supplyVoltage;
    }

    /**
     * Set referenceVoltage
     *
     * @param float $referenceVoltage
     * @return archive
     */
    public function setReferenceVoltage($referenceVoltage)
    {
        $this->referenceVoltage = $referenceVoltage;

        return $this;
    }

    /**
     * Get referenceVoltage
     *
     * @return float 
     */
    public function getReferenceVoltage()
    {
        return $this->referenceVoltage;
    }

    /**
     * Set windBatteryStatus
     *
     * @param float $windBatteryStatus
     * @return archive
     */
    public function setWindBatteryStatus($windBatteryStatus)
    {
        $this->windBatteryStatus = $windBatteryStatus;

        return $this;
    }

    /**
     * Get windBatteryStatus
     *
     * @return float 
     */
    public function getWindBatteryStatus()
    {
        return $this->windBatteryStatus;
    }

    /**
     * Set outTempBatteryStatus
     *
     * @param float $outTempBatteryStatus
     * @return archive
     */
    public function setOutTempBatteryStatus($outTempBatteryStatus)
    {
        $this->outTempBatteryStatus = $outTempBatteryStatus;

        return $this;
    }

    /**
     * Get outTempBatteryStatus
     *
     * @return float 
     */
    public function getOutTempBatteryStatus()
    {
        return $this->outTempBatteryStatus;
    }

    /**
     * Set inTempBatteryStatus
     *
     * @param float $inTempBatteryStatus
     * @return archive
     */
    public function setInTempBatteryStatus($inTempBatteryStatus)
    {
        $this->inTempBatteryStatus = $inTempBatteryStatus;

        return $this;
    }

    /**
     * Get inTempBatteryStatus
     *
     * @return float 
     */
    public function getInTempBatteryStatus()
    {
        return $this->inTempBatteryStatus;
    }
}
