<?php

namespace SyntaxError\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchiveDayInhumidity
 *
 * @ORM\Table(name="archive_day_inHumidity", uniqueConstraints={@ORM\UniqueConstraint(name="dateTime", columns={"dateTime"})})
 * @ORM\Entity
 */
class ArchiveDayInhumidity
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


}
