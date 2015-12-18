<?php

namespace SyntaxError\ApiBundle\Service;

use Symfony\Component\HttpFoundation\ParameterBag;
use SyntaxError\ApiBundle\Tools\Jsoner;

class ArchiveDayService
{
    private $day;

    private $month;

    private $year;

    private $datetime;

    private $factories;

    private $serviceName;

    public function __construct(DayService $dayService, MonthService $monthService, YearService $yearService)
    {
        $this->day = $dayService;
        $this->month = $monthService;
        $this->year = $yearService;
    }

    public function handleDate(\DateTime $dateTime)
    {
        $this->datetime = $dateTime;
        return $this;
    }

    public function initService($name)
    {
        if( property_exists($this, $name) ) {
            foreach(get_class_methods( $this->{$name} ) as $method) {
                if( preg_match('/create/', $method) ) {
                    $this->factories[] = strtolower( str_replace('create', '', $method) );
                }
            }
            $this->serviceName = $name;
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
                if( method_exists($this->{$this->serviceName}, $methodName) ) {
                    $data[$key] = call_user_func_array(
                        [$this->{$this->serviceName}, $methodName], [$this->datetime]
                    );
                }
            }
        } else {
            foreach($this->factories as $factory) {
                $methodName = "create".ucfirst($factory);
                $data[$factory] = call_user_func_array(
                    [$this->{$this->serviceName}, $methodName], [$this->datetime]
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
            $this->{$this->serviceName}->highFormatter($this->datetime, ucfirst(strtolower($type)))
        );
        return $jsoner;
    }

    private function validateInit()
    {
        if($this->serviceName === null) {
            throw new \RuntimeException("Not initialized service.");
        }

        if(!($this->datetime instanceof \DateTime)) {
            throw new \RuntimeException("Not handled DateTime.");
        }
    }

}
