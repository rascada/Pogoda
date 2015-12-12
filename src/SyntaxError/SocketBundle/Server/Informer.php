<?php

namespace SyntaxError\SocketBundle\Server;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Informer
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param $pathToLog
     */
    public function __construct($pathToLog)
    {
        $pathArray = explode(DIRECTORY_SEPARATOR, $pathToLog);
        $logDir = '';
        $pathArrayCnt = count($pathArray);
        foreach($pathArray as $i => $dirOrFile) {
            if( $i < $pathArrayCnt-1) $logDir .= "/$dirOrFile";
        }
        if( !is_writable($logDir) ) {
            throw new \RuntimeException("Permission denied to '$logDir' directory.");
        }
        $this->logger = new Logger('WebSocket');
        $this->logger->pushHandler(new StreamHandler($pathToLog, Logger::DEBUG));
    }

    /**
     * @param $clientIp
     * @param \Exception $e
     * @param null $errorMessage
     * @return Informer
     */
    public function addCriticalError($clientIp, \Exception $e, $errorMessage = null)
    {
        $errorMessage = $errorMessage === null ? '' : $errorMessage;
        $this->logger->addCritical( "[$clientIp] $errorMessage: ".$e->getMessage() );
        echo "ERROR: [$clientIp] $errorMessage: ".$e->getMessage().PHP_EOL;
        return $this;
    }

    /**
     * @param $clientIp
     * @param $message
     * @return Informer
     */
    public function addAlert($clientIp, $message)
    {
        $this->logger->addAlert("[$clientIp] $message");
        echo "ALERT: [$clientIp] $message".PHP_EOL;
        return $this;
    }

    /**
     * @param $clientIp
     * @param $message
     * @return Informer
     */
    public function addInfo($clientIp, $message)
    {
        $this->logger->addInfo("[$clientIp] $message");
        echo "INFO: [$clientIp] $message".PHP_EOL;
        return $this;
    }

    /**
     * @param $id
     * @param $ip
     * @return Informer
     */
    public function addClient($id, $ip)
    {
        $clients = is_readable(Config::hostsPath) ? json_decode(file_get_contents(Config::hostsPath)) : new \stdClass;
        $clients->{$id} = [
            'ip' => $ip."", 'connected' => (new \DateTime('now'))->format("Y-m-d H:i:s")
        ];
        file_put_contents(Config::hostsPath, json_encode($clients));
        return $this;
    }

    /**
     * @param $id
     * @return Informer
     */
    public function removeClient($id)
    {
        $clients = is_readable(Config::hostsPath) ? json_decode(file_get_contents(Config::hostsPath)) : new \stdClass;
        unset( $clients->{$id} );
        file_put_contents(Config::hostsPath, json_encode($clients));
        return $this;
    }
}
