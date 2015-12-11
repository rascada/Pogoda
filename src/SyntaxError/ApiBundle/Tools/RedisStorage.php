<?php
/**
 * Created by PhpStorm.
 * User: marcin
 * Date: 29.11.15
 * Time: 14:46
 */

namespace SyntaxError\ApiBundle\Tools;


class RedisStorage
{
    public static function createManager()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        return $redis;
    }
}
