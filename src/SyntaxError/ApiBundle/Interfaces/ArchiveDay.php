<?php

namespace SyntaxError\ApiBundle\Interfaces;

/**
 * Interface ArchiveDay
 * All entities without 'Archive' implements this interface.
 *
 * @package SyntaxError\ApiBundle\Interfaces
 */
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
