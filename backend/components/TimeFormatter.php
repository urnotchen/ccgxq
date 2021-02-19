<?php

namespace backend\components;

use yii\base\Object;

/**
 * TimeFormatter class file.
 * @Author haoliang
 * @Date 15.05.2015 14:44
 */
class TimeFormatter extends Object
{

    public $dateFormat     = 'Y-m-d';
    public $timeFormat     = 'H:i:s';
    public $datetimeFormat = 'Y-m-d H:i:s';
    public $hourFormat = 'H:i';

    private $_todayTimestamp, $_yesterdayTimestamp, $_thisYear;

    public function humanReadable($timestamp)
    {/*{{{*/
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = $this->getTodayTimestamp();
        $yesterdayTimestamp = $todayTimestamp - $dayTimestamp;
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;

        # ... yesterday ... today ... tomorrow ...
        if ($timestamp < $yesterdayTimestamp) {
            return date('Y-m-d H:i', $timestamp);
        } elseif ($timestamp < $todayTimestamp) {
            return '昨天 ' . date('H:i', $timestamp);
        } elseif ($timestamp < $tomorrowTimestamp) {
            return '今天 ' . date('H:i', $timestamp);
        } else {
            return date('Y-m-d H:i', $timestamp);
        }

    }/*}}}*/

    public function humanReadable2($timestamp)
    {
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = $this->getTodayTimestamp();
        $thisYear = $this->getThisYearTimestamp();
        $yesterdayTimestamp = $todayTimestamp - $dayTimestamp;
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;
        $dayAfterTomorrowTimestamp = $todayTimestamp + $dayTimestamp*2;

        # ... yesterday ... today ... tomorrow ...the day after tomorrow
        if ($timestamp < $thisYear) {
            return date('Y-m-d', $timestamp);
        } elseif ($timestamp < $yesterdayTimestamp) {
            return date('m-d', $timestamp);
        } elseif ($timestamp < $todayTimestamp) {
            return '<small style="color: #ff212a">昨天</small>';
        } elseif ($timestamp < $tomorrowTimestamp) {
            return '<small style="color: #009933">今天</small>';
        } elseif ($timestamp < $dayAfterTomorrowTimestamp) {
            return '明天';
        } else {
            return date('m-d', $timestamp);
        }

    }

    public function humanReadable3($timestamp)
    {
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = $this->getTodayTimestamp();
        $thisYear = $this->getThisYearTimestamp();
        $yesterdayTimestamp = $todayTimestamp - $dayTimestamp;
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;

        # ... yesterday ... today ... tomorrow ...
        if ($timestamp < $thisYear) {
            return date('Y-m-d', $timestamp);
        } elseif ($timestamp < $yesterdayTimestamp) {
            return date('m-d', $timestamp);
        } elseif ($timestamp < $todayTimestamp) {
            return '昨天 ' . date('H:i', $timestamp);
        } elseif ($timestamp < $tomorrowTimestamp) {
            $seconds = time() - $timestamp;
            if($seconds < 3600) {
                $minutes = round($seconds / 60);
                return $minutes . '分钟前';
            }
            return '今天 ' . date('H:i', $timestamp);
        } else {
            return date('m-d', $timestamp);
        }

    }

    public function chatReadable($timestamp){
        if (empty($timestamp)) return null;
        $thisYear = $this->getThisYearTimestamp();
        $todayTimestamp = $this->getTodayTimestamp();
        if($timestamp < $thisYear){
            return date("Y-m-d H:i", $timestamp);
        }else if($timestamp < $todayTimestamp){
            return date("m-d H:i", $timestamp);
        }else{
            return date("H:i", $timestamp);
        }

    }

    public function humanReadableAd($timestamp)
    {
        if (empty($timestamp)) return null;

        $dayTimestamp = 60 * 60 * 24;
        $todayTimestamp = $this->getTodayTimestamp();
        $tomorrowTimestamp = $todayTimestamp + $dayTimestamp;
        $afterTomorrowTimestamp = $tomorrowTimestamp + $dayTimestamp;
        # ... yesterday ... today ... tomorrow ...
        if ($timestamp < $todayTimestamp) {
            return date('Y-m-d H:i', $timestamp);
        } elseif ($timestamp < $tomorrowTimestamp) {
            return '今天 ' . date('H:i', $timestamp);
        } elseif ($timestamp < $afterTomorrowTimestamp) {
            return '明天 ' . date('H:i', $timestamp);
        } else {
            return date('Y-m-d H:i', $timestamp);
        }
    }

    public function getTodayTimestamp()
    {/*{{{*/
        if ($this->_todayTimestamp === null) {
            $this->_todayTimestamp = strtotime(date('Y-m-d', time()));
        }
        return $this->_todayTimestamp;
    }/*}}}*/

    public function getThisYearTimestamp()
    {/*{{{*/
        if ($this->_thisYear === null) {
            $this->_thisYear = strtotime('2016-01-01 00:00:00');
        }
        return $this->_thisYear;
    }/*}}}*/

    public function getYesterdayTimestamp()
    {/*{{{*/
        if ($this->_yesterdayTimestamp === null) {
            $this->_yesterdayTimestamp = strtotime( date('Y-m-d', time()) . ' -1 days');
        }
        return $this->yesterdayTimestamp;
    }/*}}}*/

    public function getRelatedDayTimestamp($relatedDay)
    {/*{{{*/
        return strtotime(date($this->dateFormat, time()) . "{$relatedDay} days");
    }/*}}}*/

    public function input($timestamp = null, $format = 'datetime')
    {/*{{{*/

        if (empty($timestamp))
            $timestamp = time();

        $format = $format. 'Format';

        return date($this->$format, $timestamp);
    }/*}}}*/

    public function formatYMD($timestamp){

        return date($this->dateFormat,$timestamp) ;
    }

    public function formatHI($timestamp){

        return date($this->hourFormat,$timestamp) ;
    }


}
