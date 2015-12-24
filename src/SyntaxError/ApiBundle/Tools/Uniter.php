<?php

namespace SyntaxError\ApiBundle\Tools;

class Uniter
{
    const temp = "℃";

    const trend = "/h";

    const humidity = "%";

    const barometer = "hPa";

    const speed = "km/h";

    const rain = "mm";

    const deg = "deg";

    public static function kmph2knots($kmph)
    {
        return $kmph * 0.539956803;
    }

    public static function getWindChill($kmph, $temp)
    {
        $wind = static::kmph2knots($kmph) * 1.852;
        $wind2 = pow($wind, 0.16);
        $wind_chill = (13.12 + 0.6215 * $temp - 11.37 * $wind2 + 0.3965 * $temp * $wind2);
        $wind_chill = round($wind_chill, 2);
        $wind_chill = ($wind <= 2.5) ? $temp : $wind_chill;
        $wind_chill = ($temp > 12) ? $temp : $wind_chill;
        return $wind_chill;
    }

    public static function getTrend(array $values, $key)
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

    public static function windDirPl($deg)
    {
        if($deg<20 || $deg>=320) return "z północy";
        else if($deg>=20 && $deg<70) return "z północnego wschodu";
        else if($deg>=70 && $deg<110) return "ze wschodu";
        else if($deg>=110 && $deg<160) return "z południowego wschodu";
        else if($deg>=160 && $deg<215) return "z południa";
        else if($deg>=215 && $deg<240) return "z południowego zachodu";
	    else if($deg>=240 && $deg<285) return "z zachodu";

        return "z północnego zachodu";
    }
}
