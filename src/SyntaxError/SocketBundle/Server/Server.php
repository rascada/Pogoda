<?php

namespace SyntaxError\SocketBundle\Server;

use Ratchet\ConnectionInterface;
use React\EventLoop\LoopInterface;
use Ratchet\MessageComponentInterface;

class Server implements MessageComponentInterface
{
    /**
     * @var \SplObjectStorage
     */
    protected $clients;

    /**
     * @var Informer
     */
    protected $info;

    /**
     * @var LoopInterface
     */
    protected $loop;

    /**
     * @var array
     */
    protected $config;

    public function __construct(LoopInterface $loop, Informer $informer, array $config)
    {
        $this->clients = new \SplObjectStorage;
        $this->info = $informer;
        $this->loop = $loop;
        $this->config = $config;
    }

    /**
     * @param ConnectionInterface $conn
     * @return array
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $ip = isset($conn->remoteAddress) ? $conn->remoteAddress : "Unknown";
        $realIp = $conn->WebSocket->request->getHeader('X-Real-IP');
        if($ip == '127.0.0.1' && $realIp != '127.0.0.1') $ip = $realIp;
        $id = isset($conn->resourceId) ? $conn->resourceId : 0;
        $this->info->addInfo($ip, "New connection as $id id.");
        $this->info->addClient($id, $ip);
        return ['ip' => $ip, 'id' => $id];
    }

    /**
     * @param ConnectionInterface $conn
     * @param string $msg
     * @return array
     */
    public function onMessage(ConnectionInterface $conn, $msg)
    {
        $ip = isset($conn->remoteAddress) ? $conn->remoteAddress : "Unknown";
        $realIp = $conn->WebSocket->request->getHeader('X-Real-IP');
        if($ip == '127.0.0.1' && $realIp != '127.0.0.1') $ip = $realIp;
        $id = isset($conn->resourceId) ? $conn->resourceId : 0;
        return ['ip' => $ip, 'id' => $id];
    }

    /**
     * @param ConnectionInterface $conn
     * @return array
     */
    public function onClose(ConnectionInterface $conn)
    {
        $ip = isset($conn->remoteAddress) ? $conn->remoteAddress : "Unknown";
        $realIp = $conn->WebSocket->request->getHeader('X-Real-IP');
        if($ip == '127.0.0.1' && $realIp != '127.0.0.1') $ip = $realIp;
        $id = isset($conn->resourceId) ? $conn->resourceId : 0;
        $this->info->addInfo($ip, "Connection $id closed.");
        $this->info->removeClient($id);
        $this->clients->detach($conn);
        return ['ip' => $ip, 'id' => $id];
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $ip = isset($conn->remoteAddress) ? $conn->remoteAddress : "Unknown";
        $realIp = $conn->WebSocket->request->getHeader('X-Real-IP');
        if($ip == '127.0.0.1' && $realIp != '127.0.0.1') $ip = $realIp;
        $this->info->addCriticalError($ip, $e);
        $conn->send('Critical error. Connection aborted.')->close();
    }
}
