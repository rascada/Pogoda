<?php

namespace SyntaxError\SocketBundle\Server;

use React\EventLoop\Factory;
use React\Socket\Server;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class Creator
{
    private $server;

    private $informer;

    public function __construct()
    {
        $config = Config::create();
        $this->informer = new Informer( $this->createAbsoluteLogPath($config['log']) );
        $this->informer->addInfo( 'SERVER', 'Logged to '.$config['log']." file.");

        $loop = Factory::create();

        $this->server = new IoServer(
            new HttpServer(
                new WsServer(
                    new $config['task']($loop, $this->informer, $config)
                )
            ),
            $this->createSocket($config['bind'], $config['port'], $loop), $loop
        );
    }

    private function createSocket($addr, $port, $loop)
    {
        $socket = new Server($loop);
        $socket->listen($port, $addr);
        $this->informer->addInfo('SERVER', "Created socket at '$addr'");
        return $socket;
    }

    private function createAbsoluteLogPath($path)
    {
        return preg_match('/\.\./', $path) ? __DIR__.$path : $path;
    }

    public function run()
    {
        $info = 'Server started at '.$this->server->socket->getPort()." port.";
        $this->informer->addInfo('SERVER', $info);
        if( !(Config::setPid()) ) {
            $this->informer->addAlert('SERVER_NOTICE', 'Cannot save pid file. Check permissions.');
        };
        $this->server->run();
        return $this;
    }
}
