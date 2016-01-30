<?php

namespace SyntaxError\ApiBundle\Weather;

use SyntaxError\ApiBundle\Tools\Uniter;

/**
 * Class Wind
 * @package SyntaxError\ApiBundle\Model\Basic
 */
class Wind
{
    /**
     * @var array
     */
    private $current = [];

    /**
     * @var array
     */
    private $gust = [];

    /**
     * Wind constructor.
     * @param Reading $currentSpeed
     * @param Reading $currentDir
     */
    public function __construct(Reading $currentSpeed, Reading $currentDir)
    {
        if(!$currentSpeed->value) $currentDir->value = null;
        $this->current['speed'] = $currentSpeed;
        $this->current['dir'] = $currentDir;
        $this->current['translated'] = $currentDir->value ? Uniter::windDirPl($currentDir->value) : null;
    }

    /**
     * @param Reading $gustSpeed
     * @param Reading $gustDir
     * @return Wind
     */
    public function setGust(Reading $gustSpeed, Reading $gustDir)
    {
        if(!$gustSpeed->value) $gustDir = null;
        $this->gust['speed'] = $gustSpeed;
        $this->gust['dir'] = $gustDir;
        $this->gust['translated'] = $gustDir->value ? Uniter::windDirPl($gustDir->value) : null;
        return $this;
    }
}
