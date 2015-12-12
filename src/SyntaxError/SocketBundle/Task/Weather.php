<?php

namespace SyntaxError\SocketBundle\Task;

use Doctrine\Common\Collections\ArrayCollection;
use SyntaxError\SocketBundle\Server\Informer;
use SyntaxError\SocketBundle\Server\Server;
use Ratchet\ConnectionInterface;
use React\EventLoop\LoopInterface;

class Weather extends Server
{
    private $provider;

    private $timers = [];

    private $events;

    public function __construct(LoopInterface $loop, Informer $informer, array $config)
    {
        parent::__construct($loop, $informer, $config);
        $this->provider = new Provider();
        $this->events = new ArrayCollection();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $client = parent::onOpen($conn);
        $this->events->set($client['id'], false);
        $conn->send( $this->provider->getBasic() );
        return $client;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $client = parent::onMessage($from, $msg);
        if (!is_numeric($msg)) {
            $from->send('I need your current timestamp.');
            $this->info->addAlert($client['ip'], "Empty timestamp from id ".$client['id'].".");
            return $client;
        }

        if($this->events->get( $client['id'] )) {
            $from->send('You have registered event.');
            $this->info->addAlert($client['ip'], "Client ".$client['id']." try double register.");
            return $client;
        }
        $this->events->set($client['id'], true);

        $time = $this->provider->calculateTime( (int)$msg );
        $this->info->addInfo(
            $client['ip'],
            "Client ".$client['id']." registers event for ".$time['wait']." seconds."
        );
        $from->send(json_encode( ['registered' => $time] ));

        /** @noinspection PhpParamsInspection */
        $this->timers[ $client['id'] ] = $this->loop->addTimer($time['wait'], function () use ($from, $client) {
            $from->send( $this->provider->getBasic() );
            $this->info->addInfo($client['ip'], "Send data to client ".$client['id'].".");
            $this->events->set($client['id'], false);
        });

        return $client;
    }

    public function onClose(ConnectionInterface $conn)
    {
        $client = parent::onClose($conn);
        $this->events->remove( $client['id'] );
        if( array_key_exists($client['id'], $this->timers) ) {
            $this->loop->cancelTimer( $this->timers[ $client['id'] ] );
        }
        unset( $this->timers[ $client['id'] ] );
        return $client;
    }
}
