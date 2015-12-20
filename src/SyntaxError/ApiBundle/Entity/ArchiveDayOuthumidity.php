<?php

namespace SyntaxError\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SyntaxError\ApiBundle\Interfaces\ArchiveDay;

/**
 * ArchiveDayOuthumidity
 *
 * @ORM\Table(name="archive_day_outHumidity", uniqueConstraints={@ORM\UniqueConstraint(name="dateTime", columns={"dateTime"})})
 * @ORM\Entity(repositoryClass="SyntaxError\ApiBundle\Repository\ArchiveDayOuthumidityRepository")
 */
class ArchiveDayOuthumidity implements ArchiveDay
{
    /**
     * @var integer
     *
     * @ORM\Column(name="dateTime", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $datetime;

    /**
     * @var float
     *
     * @ORM\Column(name="min", type="float", precision=10, scale=0, nullable=true)
     */
    private $min;

    /**
     * @var integer
     *
     * @ORM\Column(name="mintime", type="integer", nullable=true)
     */
    private $mintime;

    /**
     * @var float
     *
     * @ORM\Column(name="max", type="float", precision=10, scale=0, nullable=true)
     */
    private $max;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxtime", type="integer", nullable=true)
     */
    private $maxtime;

    /**
     * @var float
     *
     * @ORM\Column(name="sum", type="float", precision=10, scale=0, nullable=true)
     */
    private $sum;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer", nullable=true)
     */
    private $count;

    /**
     * @var float
     *
     * @ORM\Column(name="wsum", type="float", precision=10, scale=0, nullable=true)
     */
    private $wsum;

    /**
     * @var integer
     *
     * @ORM\Column(name="sumtime", type="integer", nullable=true)
     */
    private $sumtime;

    /**
     * @return int
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param int $datetime
     * @return ArchiveDayOuthumidity
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param float $min
     * @return ArchiveDayOuthumidity
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return int
     */
    public function getMintime()
    {
        return $this->mintime;
    }

    /**
     * @param int $mintime
     * @return ArchiveDayOuthumidity
     */
    public function setMintime($mintime)
    {
        $this->mintime = $mintime;

        return $this;
    }

    /**
     * @return float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param float $max
     * @return ArchiveDayOuthumidity
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxtime()
    {
        return $this->maxtime;
    }

    /**
     * @param int $maxtime
     * @return ArchiveDayOuthumidity
     */
    public function setMaxtime($maxtime)
    {
        $this->maxtime = $maxtime;

        return $this;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     * @return ArchiveDayOuthumidity
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return ArchiveDayOuthumidity
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return float
     */
    public function getWsum()
    {
        return $this->wsum;
    }

    /**
     * @param float $wsum
     * @return ArchiveDayOuthumidity
     */
    public function setWsum($wsum)
    {
        $this->wsum = $wsum;

        return $this;
    }

    /**
     * @return int
     */
    public function getSumtime()
    {
        return $this->sumtime;
    }

    /**
     * @param int $sumtime
     * @return ArchiveDayOuthumidity
     */
    public function setSumtime($sumtime)
    {
        $this->sumtime = $sumtime;

        return $this;
    }

}
