<?php

namespace SyntaxError\ApiBundle\Tools;

interface ArchiveDay
{
    public function getDatetime();

    public function getMax();

    public function getMaxtime();

    public function getMin();

    public function getMintime();

    public function getSum();

    public function getCount();
}
