<?php

namespace SyntaxError\SocketBundle\Task;

use SyntaxError\ApiBundle\Tools\Jsoner;

class Provider
{
    private $live;

    public function __construct()
    {
        $kernel = new \AppKernel('prod', false);
        $kernel->boot();
        $this->live = $kernel->getContainer()->get('syntax_error_api.live');
        $kernel->shutdown();
        unset($kernel);
    }

    public function getBasic()
    {
        $data = [];
        foreach(get_class_methods($this->live) as $method) {
            if($method != '__construct') {
                $key = strtolower( str_replace('create', '', $method) );
                $data[$key] = call_user_func( [$this->live, $method] );
            }
        }
        $jsoner = new Jsoner();
        return $jsoner->createJson($data)->getJsonString();
    }

    public function calculateTime($clientTimestamp)
    {
        $now = new \DateTime('now');
        $absoluteTime = $this->nextUpdateTime($now)->getTimestamp() - $now->getTimestamp();
        $delay = $now->getTimestamp() - $clientTimestamp;
        return [
            'wait' => $delay < 0 || $delay > 120 ? $absoluteTime : $absoluteTime+$delay,
            'delay' => $delay,
            'absolute' => $delay < 0 || $delay > 120
        ];
    }

    private function nextUpdateTime(\DateTime $now)
    {
        $nowMinutesArray[] = (int)$now->format("i")[0];
        $nowMinutesArray[] = (int)$now->format("i")[1];
        $next = (new \DateTime)->setTime(
            $now->format("H"), $now->format("i"), $now->format("s")
        );

        if ($nowMinutesArray[0] >= 5 && $nowMinutesArray[1] > 6) {
            $next->modify("+1 hour");
            $nowMinutesArray[0] = -1;
        }

        $next->setTime(
            $next->format("H"),
            $nowMinutesArray[1] < 6 && $nowMinutesArray[1] >= 0 ? $nowMinutesArray[0] . "6" : ($nowMinutesArray[0] + 1) . "1"
        );

        return $next;
    }
}
