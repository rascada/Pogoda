<?php

namespace SyntaxError\ApiBundle\Weather;

/**
 * Class Wind
 * @package SyntaxError\ApiBundle\Model\Basic
 */
class Wind
{
    /**
     * @var Reading
     */
    private $currentSpeed;

    /**
     * @var Reading
     */
    private $currentDir;

    /**
     * @var Reading
     */
    private $gustSpeed;

    /**
     * @var Reading
     */
    private $gustDir;

    /**
     * @var array
     */
    private $translatedDir = [];

    /**
     * @param $speed
     * @param $dir
     */
    public function __construct(Reading $speed, Reading $dir)
    {
        $this->currentDir = $dir;
        $this->currentSpeed = $speed;
    }

    /**
     * @param $speed
     * @param $dir
     * @return Wind
     */
    public function setGust(Reading $speed, Reading $dir)
    {
        $this->gustDir = $dir;
        $this->gustSpeed = $speed;
        return $this;
    }

    /**
     * @param array $translatedDir
     * @return Wind
     */
    public function setTranslatedDir(array $translatedDir)
    {
        $this->translatedDir = $translatedDir;

        return $this;
    }

    /**
     * @return Reading
     */
    public function getCurrentSpeed()
    {
        return $this->currentSpeed;
    }

    /**
     * @return Reading
     */
    public function getCurrentDir()
    {
        return $this->currentDir;
    }

    /**
     * @return Reading
     */
    public function getGustSpeed()
    {
        return $this->gustSpeed;
    }

    /**
     * @return Reading
     */
    public function getGustDir()
    {
        return $this->gustDir;
    }

    /**
     * @return array
     */
    public function getTranslatedDir()
    {
        return $this->translatedDir;
    }
}
