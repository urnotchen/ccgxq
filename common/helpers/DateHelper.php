<?php
/**
 * Created by PhpStorm.
 * User: WangSai
 * Date: 2016/11/30 0030
 * Time: 19:16
 */

namespace common\helpers;


use yii\base\Object;

class DateHelper extends Object
{
    public static $minute = 60;
    public static $hour = 3600;
    public static $day = 86400;

    private static $_today;

    public static function secondToDay($seconds)
    {
        $seconds = abs($seconds);
        $timeFormat = '';
        $days = floor($seconds / self::$day);

        if ($days > 0) {
            $seconds = $seconds % self::$day;
            $timeFormat .= $days . '天';
        }

        $hours = floor($seconds / self::$hour);

        if ($hours > 0) {
            $seconds = $seconds % self::$hour;
            $timeFormat .= $hours . '小时';
        }

        $minutes = floor($seconds / self::$minute);

        if ($minutes > 0) {
            $timeFormat .= $minutes . '分钟';
        }

        return $timeFormat;
    }

    /**
     * 今日零点时间戳
     * @return false|int
     */
    public static function getToday()
    {
        if (!self::$_today) {
            self::$_today = strtotime(date('Y-m-d'));
        }
        return self::$_today;
    }

    /**
     * 判断时间是否大于今天
     * @param $time
     * @return bool
     */
    public static function isGtToday($time)
    {
        $timestamp = is_numeric($time) ? $time : strtotime($time);

        $day = 24 * 60 * 60;
        $today_stamp = strtotime(date('Y-m-d'));
        if ($timestamp >= $today_stamp + $day) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 说明 : 获取月初和下月初的时间戳
     * 参数 : 年份,月份
     * 返回 : (array)
     * */
    public static function getMonthTimeStamp($year,$month){

        if($month == 12){
            $res[] = strtotime($year.'-'.$month.'-1');
            $res[] = strtotime(($year + 1),'-1-1');
        }else{
            $res[] = strtotime($year.'-'.$month.'-1');
            $res[] = strtotime($year.'-'.($month + 1).'-1');
        }
        return $res;
    }

    /*
     * 说明 : 获取最近的某个星期几
     * 参数 : 星期几,当天(0点)的时间戳
     * 返回 : 星期几的时间戳
     * */
    public static function getNearWeekDay($find_week_day,$timeStamp){

        if(!($find_week_day >= 1 && $find_week_day <= 7)){
            return '星期日期只有1到7 参数错误';
        }

        //这周有没有过去的几天有没有需要查找的星期几
        $now_week_day = date("N",$timeStamp);
        if($now_week_day >= $find_week_day){
            return $timeStamp - ($now_week_day - $find_week_day) * 86400;
        }else{
            return $timeStamp - (7 - $find_week_day + $now_week_day) * 86400;
        }
        //没有的话,上一周查找
    }
    /*
     * 说明 : 获取当前周的星期几的时间戳
     * 参数 : 星期几,当天(0点)的时间戳
     * 返回 : 星期几的时间戳
     * */
//    public static function getNearWeekDayWhole($find_week_day,$timeStamp){
//
//        if(!($find_week_day >= 1 && $find_week_day <= 7)){
//            return '星期日期只有1到7 参数错误';
//        }
//
//       return strtotime(date("Y-m-1",$timeStamp));
//    }
    /*
     * 说明 : 获取上个月今天的时间戳
     * 参数 : 当天(0点)的时间戳
     * 返回 : 时间戳
     * */
    public static function getNearMonthDay($timeStamp,$month_day){

        list($year,$month,$day) = explode('-',date("Y-m-d",$timeStamp));

        //获取上个月的最后一天的日期

        $last_month_day = date("d",strtotime($year.'-'.$month.'-1')-1);
        //如果上个月没有这一天的话,最后一天就算这一天
        if($last_month_day < $day){
            $day = $last_month_day;
        }else{
            $day = $month_day;
        }

        if($month == 1){
            $month = 12;
            $year = $year - 1;
        }else{
            $month = $month - 1;
        }

        return strtotime($year.'-'.$month.'-'.$day);

    }
    /*
     * 说明 : 获取月初的时间戳
     * 参数 : 当天(0点)的时间戳
     * 返回 : 月初的时间戳
     * */
    public static function getNearMonthDayWhole($timeStamp,$month_day = null){

        if(!$month_day){
            $timeStamp = $timeStamp - 86400;
            list($year,$month,$day) = explode('-',date("Y-m-d",$timeStamp));
        }else{
            list($year,$month,$day) = explode('-',date("Y-m-d",$timeStamp));
        }


        return strtotime($year.'-'.$month.'-1');

    }
    /*
     * 说明 : 获取下月初的时间戳
     * 参数 : 当天(0点)的时间戳
     * 返回 : 星期几的时间戳
     * */
    public static function getNextMonth($timeStamp){

        list($year,$month,$day) = explode('-',date("Y-m-d",$timeStamp));

        //获取上个月的最后一天的日期

        if($month == 12){
            $year = ++$year;
            $month = 1;
        }else{
            $month++;
        }

        return strtotime($year.'-'.$month.'-1');

    }
    /*
     * 说明 : 获取上月初的时间戳
     * 参数 : 本月1号某点的时间戳
     * 返回 : 时间戳
     * */
    public static function getLastMonth($timeStamp){

        list($year,$month,$day) = explode('-',date("Y-m-d",$timeStamp));

        //获取上个月的最后一天的日期

        if($month == 1){
            $year = --$year;
            $month = 12;
        }else{
            $month--;
        }

        return strtotime($year.'-'.$month.'-1');

    }
    /*
     * 说明 : 获取上周一的时间戳
     * 参数 : 当前周周一的时间戳
     * 返回 : 时间戳
     * */
    public static function getLastWeekMonday($timeStamp){

        return strtotime(date('Y-m-d',strtotime('-1 monday', $timeStamp)));

    }
    /*
     * 说明 : 获取本周一的时间戳
     * 参数 : 当前周周一的时间戳
     * 返回 : 时间戳
     * */
    public static function getWeekMonday($timeStamp){

        return strtotime(date('Y-m-d',strtotime('monday', $timeStamp)));

    }

    /*
     * 说明 : 获取'近七天'的始末时间戳(六天前的0点到今天晚上)
     * 参数 : 现在时间
     * */
    public static function get7daysRange($current_time){

        return [strtotime(date("Y-m-d",$current_time)) - 86400 * 6,strtotime(date("Y-m-d",$current_time)) + 86400];
    }

    public static function getNearWeek($weekNum = 12){

        $MondayTimestamp =strtotime(date("Y-m-d 00:00:00",DateHelper::getNearWeekDay(1,time())));

        for($i = 1;$i <= $weekNum;$i ++){

            $weekArr[date('W',$MondayTimestamp - $i * 7 * 86400)] = date("n-d",$MondayTimestamp - $i * 7 * 86400) .'~'.date("n-d",$MondayTimestamp - ($i - 1) * 7 * 86400);
        }

        return $weekArr;
    }

    public static function getNearMonth($monthNum = 12){

        $thisMonthTimestamp = strtotime(date('Y-m-1',time()));

//        list($year,$month) = explode('-',time());
        for($i = 0 ; $i < $monthNum ; $i ++){

            $monthArr[date("n",$thisMonthTimestamp - 1)] = date("Y",$thisMonthTimestamp - 1).'.'.date("n",$thisMonthTimestamp - 1);
            $thisMonthTimestamp = strtotime(date("Y",$thisMonthTimestamp - 1).'-'.date("n",$thisMonthTimestamp -1 )."-1 00:00:00");
        }

        return $monthArr;
    }

    public static function getYesterdayTimestamp($timestamp){

        return strtotime(date("Y-m-d",$timestamp)) - 86400;
    }
}