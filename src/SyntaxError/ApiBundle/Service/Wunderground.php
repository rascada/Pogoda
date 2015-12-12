<?php

namespace SyntaxError\ApiBundle\Service;

use SyntaxError\ApiBundle\Tools\RedisStorage;

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
        $redis = RedisStorage::createManager();
        $isOld = !$redis->exists("value_$dataName");
        if( $redis->exists($dataName) ) {
            $last = (int)$redis->get($dataName);
            $now = (new \DateTime('now'))->getTimestamp();
            if( ($now-$last)/60 > $lifeTimeInMinutes ) {
                $isOld = true;
            }
        }

        if($isOld) {
            $apiUrl = $this->rootApi.$dataName."/lang:".$this->lang."/q/".$this->place.".json";
            $redis->set("value_$dataName", file_get_contents($apiUrl));
            $redis->set( $dataName, (new \DateTime('now'))->getTimestamp() );
        }

        return $redis->get("value_$dataName");
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
