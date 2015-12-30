<?php

namespace SyntaxError\ApiBundle\Service;

use SyntaxError\ApiBundle\Tools\IconCache;

class Wunderground
{
    private $rootApi = "http://api.wunderground.com/api/d3e5e159801b834c/";

    private $lang = "PL";

    private $place = "pws:IOPOLSKI10";

    /**
     * @param $dataName
     * @param $lifeTimeInMinutes
     * @return string
     */
    public function read($dataName, $lifeTimeInMinutes)
    {
        $redis = $this->createRedis();
        if( !$redis->exists($dataName) ) {
            $apiUrl = $this->rootApi.$dataName."/lang:".$this->lang."/q/".$this->place.".json";
            $wuJson = file_get_contents($apiUrl);

            if($dataName == 'forecast') {
                $iconCache = new IconCache(
                    __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."Resources".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."images"
                );
                $wuJson = $iconCache->cacheFromWunderground($wuJson);
            }
            $redis->setEx($dataName, $lifeTimeInMinutes*60, $wuJson);
        }
        return $redis->get($dataName);

    }

    /**
     * @return \Redis
     */
    private function createRedis()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        return $redis;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return Wunderground
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     * @return Wunderground
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }
}
