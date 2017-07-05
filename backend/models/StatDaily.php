<?php

namespace backend\models;

use Yii;

class StatDaily extends \common\models\StatDaily
{

    /*
     * 数据落地,添加日活数据
     * @param $count 活跃人数
     *        $countStr 活跃人数字符串(形式是redis中的bit数组形式)
     * */
    public static function dailyRecord($count,$countStr,$beginAt,$endAt){

        $record = new self;

        $record->year = date("Y",$beginAt);
        $record->month = date("m",$beginAt);
        $record->day = date("d",$beginAt);
        $record->week = date("W",$beginAt);
        $record->begin_at = $beginAt;
        $record->end_at = $endAt;
        $record->count = $count;
        $record->daily = $countStr;

        $record->save();

    }
}
