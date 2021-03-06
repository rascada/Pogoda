<?php

namespace SyntaxError\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use SyntaxError\SocketBundle\Server\Config;

class Admin
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createDatabaseInformer()
    {
        $size = 0;
        $archiveSize = 0;
        $status = $this->em->getConnection()->fetchAll('SHOW TABLE STATUS');

        foreach ($status as $oneStatus) {
            $size += $oneStatus['Data_length'] + $oneStatus['Index_length'];
            if ($oneStatus['Name'] == 'archive') {
                $archiveSize = $oneStatus['Data_length'] + $oneStatus['Index_length'];
            }
        }

        return [
            'count' => [
                'archive' => $this->em->getRepository("SyntaxErrorApiBundle:Archive")->createQueryBuilder('a')
                    ->select('count(a)')->getQuery()->getSingleResult()[1],
                'day' => $this->em->getRepository("SyntaxErrorApiBundle:ArchiveDayRain")->createQueryBuilder('a')
                    ->select('count(a)')->getQuery()->getSingleResult()[1]
            ],

            /* Convert size to MB */
            'size' => [
                'total' => number_format($size / (1024 * 1024), 2),
                'archive' => number_format($archiveSize / (1024 * 1024), 2),
                'rest' => number_format(($size - $archiveSize) / (1024 * 1024), 2)
            ]
        ];
    }


    public function createHardwareInformer()
    {
        $lastTime = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->createQueryBuilder('a')->select('a.dateTime')
            ->orderBy('a.dateTime', 'desc')->setMaxResults(1)->getQuery()->getSingleScalarResult();

        return [
            'batteries' => $this->em->getRepository("SyntaxErrorApiBundle:Archive")->getBatteryStatus(),
            'last' => (new \DateTime())->setTimestamp($lastTime)
        ];
    }

    public function createServerInformer()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $deployRunning = $redis->exists('deploy_running') ? $redis->get('deploy_running') : "ERR: Empty redis deploy.";

        return [
            'forecast' => [
                'cached' => $redis->exists('forecast'),
                'ttl' => $redis->exists('forecast') ? gmdate("i# m@", $redis->ttl('forecast')) : null
            ],
            'astronomy' => [
                'cached' => $redis->exists('astronomy'),
                'ttl' => $redis->exists('astronomy') ? gmdate("i# m@", $redis->ttl('astronomy')) : null
            ],
            'alerts' => [
                'cached' => $redis->exists('alerts'),
                'ttl' => $redis->exists('alerts') ? gmdate("i# m@", $redis->ttl('alerts')) : null
            ],
            'deploy' => $deployRunning == "true" ? false : $deployRunning,
            'branch' => str_replace('ref: ', '', file_get_contents(__DIR__."/../../../../.git/HEAD")),
            'status' => $redis->exists('wu_requests') ? json_decode($redis->get('wu_requests')) : null
        ];
    }

    public function createSocketInformer()
    {
        $hostsObj = json_decode(file_get_contents(Config::hostsPath));
        $output = [];
        foreach(get_object_vars($hostsObj) as $client) {
            $output[] = $client;
        }
        $procOut = explode(" ", `ps auxf | grep [S]ocketBundle`)[0];

        $configPid = Config::getPid();
        $managerPath = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."SocketBundle".DIRECTORY_SEPARATOR."manager";
        $logPath = str_replace(PHP_EOL, '', `$managerPath ws:status -l`);

        return [
            'hosts' => $output,
            'pid' => is_numeric($configPid) ? (int)$configPid : false,
            'changeable' => strlen($procOut) ? $procOut == trim(`whoami`) : true,
            'log' => is_readable($logPath) ? explode(PHP_EOL, file_get_contents($logPath)) : false
        ];
    }
}
