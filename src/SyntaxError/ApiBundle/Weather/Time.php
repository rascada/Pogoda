<?php

namespace SyntaxError\ApiBundle\Weather;


class Time
{
    /**
     * @var Reading
     */
    private $data;

    /**
     * @var Reading
     */
    private $next;

    public function __construct(Reading $data)
    {
        $this->data = $data;
    }

    /**
     * @return Reading
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param Reading $next
     * @return Time
     */
    public function setNext(Reading $next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * @return Reading
     */
    public function getData()
    {
        return $this->data;
    }
}
