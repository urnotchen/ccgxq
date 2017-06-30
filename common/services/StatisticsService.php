<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/30
 * Time: 9:29
 */

namespace common\services;


class StatisticsService extends BizService{


    public function setAU($timestamp,$userId){

        $now = $timestamp;

        $dayTimestamp = strtotime(date("Y-m-d",$now));
        $weekTimestamp = strtotime(date('Y-m-d',($now-((date('w',$now)==0?7:date('w',$now))-1)*24*3600)));
        $monthTimestamp = strtotime(date("Y-m-1",$now));
        //日活
        \Yii::$app->redis->setbit("dau_".$dayTimestamp,$userId,1);
        //周活
        \Yii::$app->redis->setbit("wau_".$weekTimestamp,$userId,1);
        //月活
        \Yii::$app->redis->setbit("mau_".$monthTimestamp,$userId,1);
    }

    public function setCommentCount($now,$userId){

        $now = strtotime(date("Y-m-d",$now));
        //每日多少人评论了电影
        \Yii::$app->redis->setbit("comment_d_".$now,$userId,1);

    }

    /*
     * 电影斩标记电影统计
     * */
    public function zhanUserChoiceCount($now,$choice,$userId){

        $now = strtotime(date("Y-m-d",$now));

        //每日有多少人甩电影斩标记了电影
        \Yii::$app->redis->setbit("zhan_d_{$choice}".$now,$userId,1);
    }
}