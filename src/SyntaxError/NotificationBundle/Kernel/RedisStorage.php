<?php

namespace SyntaxError\NotificationBundle\Kernel;


class RedisStorage
{
    /**
     * Connection with redis server.
     *
     * @var \Redis
     */
    private $redis;

    /**
     * Array of subscribers emails.
     *
     * @var array
     */
    private $subscribers = [];

    /**
     * Prefix for all keys inr redis.
     *
     * @const prefix
     */
    const prefix = 'syntax_error_weather_email_';

    /**
     * RedisStorage constructor.
     * @param $address
     */
    public function __construct($address)
    {
        $this->redis = new \Redis;
        $this->redis->connect($address);
    }

    /**
     * Check notify is unlocked for sending.
     *
     * @param $notifyName
     * @return bool
     */
    public function isLocked($notifyName)
    {
        return $this->redis->exists(static::prefix.$notifyName);
    }

    /**
     * Lock notify on 24 hours.
     *
     * @param $notifyName
     * @return bool
     */
    public function lock($notifyName)
    {
        return $this->redis->setex(static::prefix.$notifyName, 3600*24, 'true');
    }

    /**
     * Return array of subscribers emails.
     *
     * @return array
     */
    public function getSubscribers()
    {
        if(!count($this->subscribers)) $this->loadSubscribers();
        return $this->subscribers;
    }

    /**
     * Load subscribers from Redis.
     *
     * @return $this
     */
    private function loadSubscribers()
    {
        if(!$this->redis->exists(static::prefix.'subscribers')) $this->redis->set(static::prefix.'subscribers', '[]');
        $decoded = json_decode($this->redis->get(static::prefix.'subscribers'));
        $this->subscribers = $decoded !== null && is_array($decoded) ? $decoded : [];
        return $this;
    }
}
