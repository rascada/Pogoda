<?php

namespace SyntaxError\ApiBundle\Record;

use Symfony\Component\HttpFoundation\ParameterBag;
use SyntaxError\ApiBundle\Interfaces\ArchiveService;
use SyntaxError\ApiBundle\Tools\Jsoner;

class ArchiveManager
{
    /**
     * @var ArchiveService|null
     */
    private $service;

    /**
     * @var \DateTime|null
     */
    private $datetime;

    /**
     * @var array
     */
    private $factories = [];

    /**
     * @param \DateTime $dateTime
     * @return ArchiveManager
     */
    public function handleDate(\DateTime $dateTime)
    {
        $this->datetime = $dateTime->setTime(0,0,0);
        return $this;
    }

    /**
     * @param ArchiveService $archiveService
     * @return ArchiveManager
     */
    public function initService(ArchiveService $archiveService)
    {
        $this->service = $archiveService;
        foreach(get_class_methods($this->service) as $method) {
            if( preg_match('/create/', $method) ) {
                $this->factories[] = strtolower( str_replace('create', '', $method) );
            }
        }
        return $this;
    }

    /**
     * @param ParameterBag $requestQuery
     * @return Jsoner
     */
    public function getRecords(ParameterBag $requestQuery)
    {
        $this->validateInit();
        $userQuery = false;
        foreach($this->factories as $factory) {
            if( $requestQuery->has($factory) ) $userQuery = true;
        }

        $data = [];
        if($userQuery) {
            foreach($requestQuery->all() as $key => $value) {
                $methodName = "create".ucfirst($key);
                if( method_exists($this->service, $methodName) ) {
                    $data[$key] = call_user_func_array(
                        [$this->service, $methodName], [$this->datetime]
                    );
                }
            }
        } else {
            foreach($this->factories as $factory) {
                $methodName = "create".ucfirst($factory);
                $data[$factory] = call_user_func_array(
                    [$this->service, $methodName], [$this->datetime]
                );
            }
        }

        $jsoner = new Jsoner();
        $jsoner->createJson($data);
        return $jsoner;
    }

    /**
     * @param $type
     * @return Jsoner
     */
    public function getChart($type)
    {
        $this->validateInit();
        $jsoner = new Jsoner();
        $jsoner->createJson(
            $this->service->highFormatter($this->datetime, ucfirst(strtolower($type)))
        );
        return $jsoner;
    }

    /**
     * @void
     */
    private function validateInit()
    {
        if(!($this->service instanceof ArchiveService)) {
            throw new \RuntimeException("Not initialized service.");
        }

        if(!($this->datetime instanceof \DateTime)) {
            throw new \RuntimeException("Not handled DateTime.");
        }
    }

}
