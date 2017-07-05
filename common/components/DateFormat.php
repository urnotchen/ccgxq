<?php

namespace common\components;

class DateFormat extends \yii\base\Object
{
    const MINUTE = 60, HOUR = 3600, DAY = 86400;

    public static $dateFormat     = 'Y-m-d';
    public static $timeFormat     = 'H:i:s';
    public static $datetimeFormat = 'Y-m-d H:i:s';

    private static $_today, $_yesterday, $_thisWeek, $_thisMonth, $_lastMonth, $_thisYear, $_NextYear;

    /**
     * 将2016-12-01~2016-12-07转换为时间戳数组
     * @param $dateStr
     * @param string $separator
     * @return array|bool
     */
    public static function convertDateRangeToTimestampRange($dateStr, $separator = '~')
    {
        $timeRangeArr = explode($separator, $dateStr);

        if (! (isset($timeRangeArr[0]) && isset($timeRangeArr[1]))) {
            return false;
        }

        $beginTime = strtotime($timeRangeArr[0]);
        $endTime = strtotime($timeRangeArr[1]);

        #如果起始时间大于等于结束时间，则返回false
        if (!($beginTime && $endTime && $beginTime < $endTime)) {
            return false;
        }

        return [
            $beginTime,
            $endTime
        ];
    }

    /**
     * @param $timestamp
     * @return false|null|string
     */
    public static function humanReadableDateTime($timestamp)
    {
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = self::getTodayTimestamp();
        $thisYear = self::getThisYearTimestamp();
        $nextYear = self::getNextYearTimestamp();
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;

        if ($timestamp < $thisYear || $timestamp > $nextYear) {
            return date('Y-m-d H:i', $timestamp);
        } elseif ($timestamp < $todayTimestamp || $timestamp > $tomorrowTimestamp) {
            return date('m月d日 H:i', $timestamp);
        } else {
            $seconds = time() - $timestamp;
            if($seconds >= 0){
                if($seconds < 60){
                    return '刚刚';
                }else if($seconds < 3600) {
                    $minutes = round($seconds / 60);
                    return $minutes . '分钟前';
                }
            }
            return '今天 ' . date('H:i', $timestamp);
        }
    }

    public static function humanChatDateTime($timestamp){
        if (empty($timestamp)) return null;
        $thisYear = self::getThisYearTimestamp();
        $todayTimestamp = self::getTodayTimestamp();
        if($timestamp < $thisYear){
            return date("Y-m-d H:i", $timestamp);
        }else if($timestamp < $todayTimestamp){
            return date("m-d H:i", $timestamp);
        }else{
            return date("H:i", $timestamp);
        }

    }

    /**
     * 获取今天的起始时间
     */
    public static function getTodayTimestamp()
    {
        if (!self::$_today) {
            self::$_today = strtotime(date('Y-m-d'));
        }
        return self::$_today;
    }

    public static function getThisYearTimestamp()
    {
        if (self::$_thisYear === null) {
            self::$_thisYear = strtotime(date('Y') . '-01-01');
        }
        return self::$_thisYear;
    }

    public static function getNextYearTimestamp()
    {
        if (self::$_NextYear === null) {
            self::$_NextYear = strtotime((date('Y') + 1) . '-01-01');

        }
        return self::$_NextYear;
    }

    public static function humanReadableDate($timestamp)
    {
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = self::getTodayTimestamp();
        $thisYear = self::getThisYearTimestamp();
        $nextYear = self::getNextYearTimestamp();
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;

        if ($timestamp < $thisYear || $timestamp > $nextYear) {
            return date('Y-m-d', $timestamp);
        } elseif ($timestamp < $todayTimestamp || $timestamp > $tomorrowTimestamp) {
            return date('m月d日', $timestamp);
        } else {
            return '今天';
        }
    }

    public function humanReadable3($timestamp)
    {
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = $this->getTodayTimestamp();
        $thisYear = $this->getThisYearTimestamp();
        $nextYear = $this->getNextYearTimestamp();
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;

        if ($timestamp < $thisYear || $timestamp > $nextYear) {
            return date('Y-m-d H:i', $timestamp);
        } elseif ($timestamp < $todayTimestamp || $timestamp >= $tomorrowTimestamp) {
            return date('m月d日 H:i', $timestamp);
        } else {
            $seconds = time() - $timestamp;
            if($seconds >= 0){
                if($seconds < 60){
                    return '刚刚';
                }else if($seconds < 3600) {
                    $minutes = round($seconds / 60);
                    return $minutes . '分钟前';
                }
            }
            return '今天 ' . date('H:i', $timestamp);
        }
    }

    public static function getDayBeginByTimestamp($timestamp = null)
    {
        return strtotime(date('Y-m-d', $timestamp));
    }

    /**
     * 获取昨天的起始时间
     */
    public static function getYesterdayTimestamp()
    {
        if(!self::$_yesterday){
            self::$_yesterday = self::getTodayTimestamp() - self::DAY;
        }
        return self::$_yesterday;
    }

    public static function getThisWeekTimestamp()
    {
        if (self::$_thisWeek === null) {
            self::$_thisWeek = mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
        }
        return self::$_thisWeek;
    }

    public static function getThisMonthTimestamp()
    {
        if (self::$_thisMonth === null) {
            self::$_thisMonth = strtotime(date('Y-m'));
        }
        return self::$_thisMonth;
    }

    public static function getLastMonthTimestamp()
    {
        if (self::$_lastMonth === null) {
            self::$_lastMonth = strtotime(date('Y') . '-' . (date('m') - 1));
        }
        return self::$_lastMonth;
    }
}
