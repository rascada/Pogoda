<?php

namespace SyntaxError\NotificationBundle\Tools;
/**
 * Trait DateTimer
 *
 * Creating specified dates for weewx database primary keys.
 */
trait DateTimer
{
    protected function todayMidnight()
    {
        $today = new \DateTime();
        (new \DateTime())->format("I") == 1 ? $today->setTime(0,0,0) : $today->setTime(1,0,0);
        return $today;
    }

    protected function monthStart()
    {
        $start = $this->todayMidnight();
        $start->setDate($start->format("Y"), $start->format("m"), 1);
        return $start;
    }

    protected function monthEnd()
    {
        $end = $this->todayMidnight();
        $end->setDate($end->format("Y"), $end->format("m"), $end->format("t"));
        return $end;
    }

    protected function yearStart()
    {
        $start = $this->todayMidnight();
        $start->setDate($start->format("Y"), 1, 1);
        return $start;
    }

    protected function yearEnd()
    {
        $end = $this->todayMidnight();
        $end->setDate($end->format("Y"), 12, 31);
        return $end;
    }

}
