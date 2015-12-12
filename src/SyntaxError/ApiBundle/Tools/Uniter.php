<?php

namespace SyntaxError\ApiBundle\Tools;

class Uniter
{
    public function kmph2knots($kmph)
    {
        return $kmph * 0.539956803;
    }

    public function getWindChill($kmph, $temp)
    {
        $wind = $this->kmph2knots($kmph) * 1.852;
        $wind2 = pow($wind, 0.16);
        $wind_chill = (13.12 + 0.6215 * $temp - 11.37 * $wind2 + 0.3965 * $temp * $wind2);
        $wind_chill = round($wind_chill, 2);
        $wind_chill = ($wind <= 2.5) ? $temp : $wind_chill;
        $wind_chill = ($temp > 12) ? $temp : $wind_chill;
        return $wind_chill;
    }

    public function getTrend(array $values, $key)
    {
        if(!$values || count($values) < 2) {
            return 0;
        }
        $trends = [];
        foreach($values as $i => $value) {
            if( array_key_exists($i+1, $values) ) {
                $trends[] = $value[$key] - $values[$i+1][$key];
            }
        }

        return array_sum($trends)/count($trends);
    }
}
