<?php

namespace lens;


class Date
{
    /**
     * 获得某个日期 $num 天后的日期
     *
     * @param int $num
     * @param string $format
     * @param string $date 日期或者时间戳，默认时取今天
     * @return string
     */
    public static function dayAfter($num, $format = 'Y-m-d H:i:s', $date = '')
    {
        $time = $date ? $date : time();
        if (!is_numeric($time)) {
            $time = strtotime($time);
        }
        $timeAfter = $time + 86400 * $num;
        
        return date($format, $timeAfter);
    }
    
    /**
     * 获得某个日期 $num 天前的日期
     *
     * @param int $num
     * @param string $format
     * @param string $date 日期或者时间戳，默认取今天
     * @return string
     */
    public static function dayBefore($num, $format = 'Y-m-d H:i:s', $date = '')
    {
        $time = $date ? $date : time();
        if (!is_numeric($time)) {
            $time = strtotime($time);
        }
        $timeBefore = $time - 86400 * $num;
        
        return date($format, $timeBefore);
    }
}