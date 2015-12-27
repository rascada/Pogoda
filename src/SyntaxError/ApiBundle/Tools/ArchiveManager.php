<?php

namespace SyntaxError\ApiBundle\Tools;

use Symfony\Component\HttpFoundation\ParameterBag;
use SyntaxError\ApiBundle\Interfaces\ArchiveService;

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

    public function handleDate(\DateTime $dateTime)
    {
        $this->datetime = $dateTime->setTime(0,0,0);
        return $this;
    }

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

    public function getChart($type)
    {
        $this->validateInit();
        $jsoner = new Jsoner();
        $jsoner->createJson(
            $this->service->highFormatter($this->datetime, ucfirst(strtolower($type)))
        );
        return $jsoner;
    }

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
