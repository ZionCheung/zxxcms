<?php

namespace lib;

class FormatTime
{
    /**
     * @param $time
     * @return int|string
     * 秒转换
     */
    public static function SecondConversion($time) {
        $formatTime = '';
        $timeArr = [
            86400 => '天',
            3600 => '时',
            60 => ':',
            1 => ''
        ];
        foreach ($timeArr as $key => $value) {
            if ($time >= $key) $formatTime .= floor($time/$key) . $value;
            $time %= $key;
        }
        if($formatTime == ''){
            $formatTime=0;
        }
        return $formatTime;
    }

    /**
     * @param $times
     * @return string
     * 秒转换 00:00:00
     */
    public static function SecondConversionTwo($times) {
        $result = '00:00:00';
        if ($times>0) {
            $hour = floor($times/3600);
            $minute = floor(($times-3600 * $hour)/60);
            $second = floor((($times-3600 * $hour) - 60 * $minute) % 60);
            $hour = strlen($hour) == 1 ? '0' . $hour : $hour;
            $minute = strlen($minute) == 1 ? '0' . $minute : $minute;
            $second = strlen($second) == 1 ? '0' . $second : $second;
            $result = $hour.':'.$minute.':'.$second;
        }
        return $result;
    }
}
