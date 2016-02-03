<?php

namespace SyntaxError\ApiBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use SyntaxError\ApiBundle\Tools\IconCache;

/**
 * Class Wunderground
 * @package SyntaxError\ApiBundle\Service
 */
class Wunderground
{
    /**
     * Root url to wunderground api.
     *
     * @var string
     */
    private $rootApi = "http://api.wunderground.com/api/";

    /**
     * Language of translation.
     *
     * @var string
     */
    private $lang = "PL";

    /**
     * Wunderground place code.
     *
     * @var string
     */
    private $place = "pws:IOPOLSKI10";

    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * Wunderground constructor.
     * @param RequestStack $requestStack
     * @param ContainerInterface $container
     */
    public function __construct(RequestStack $requestStack, ContainerInterface $container)
    {
        $this->request = $requestStack->getMasterRequest();
        $this->rootApi .= $container->getParameter('wu_token')."/";
    }

    /**
     * Read data from cache if exist.
     * Else download data from wu-api and set to redis with life time in minutes.
     *
     * Cache forecast icons and replace links.
     *
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

            $wuRequests = $redis->exists('wu_requests') ? json_decode($redis->get('wu_requests')) : new \stdClass;
            $dataStatus = property_exists($wuRequests, $dataName) ? $wuRequests->{$dataName} : new \stdClass;
            $dataStatus->total = property_exists($dataStatus, 'total') ? $dataStatus->total+1 : 1;

            if( !property_exists($dataStatus, 'today') ) $dataStatus->today = new \stdClass;
            if( !property_exists($dataStatus->today, 'value') ) $dataStatus->today->value = 1;

            if( property_exists($dataStatus->today, 'date') && $dataStatus->today->date == (new \DateTime('now'))->format("Y-m-d") ) {
                $dataStatus->today->value++;
            } else {
                $dataStatus->today->date = (new \DateTime('now'))->format("Y-m-d");
                $dataStatus->today->value = 1;
            }

            $wuRequests->{$dataName} = $dataStatus;
            $redis->set('wu_requests', json_encode($wuRequests));

            if($dataName == 'forecast') {
                $iconCache = new IconCache(
                    __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."Resources".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."images"
                );
                $fullServerName = $this->request->isSecure() ? "https://".$this->request->getHost() : $this->request->getHost();
                $iconCache->setServerName($fullServerName);
                $wuJson = $iconCache->cacheFromWunderground($wuJson);
            }
            $redis->setEx($dataName, $lifeTimeInMinutes*60, $wuJson);
        }
        return $redis->get($dataName);

    }

    /**
     * Create redis instance connected to localhost.
     *
     * @return \Redis
     */
    private function createRedis()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        return $redis;
    }

    /**
     * Get translation language.
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set translation language.
     *
     * @param string $lang
     * @return Wunderground
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get WU place code.
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set WU place code.
     *
     * @param string $place
     * @return Wunderground
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }
}
