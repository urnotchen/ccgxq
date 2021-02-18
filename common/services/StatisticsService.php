<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/30
 * Time: 9:29
 */

namespace common\services;


class StatisticsService extends BizService{

    const DAY = 86400 , HOUR = 3600 ,MINUTE = 60;

    public function setAU($timestamp,$userId){

        $now = $timestamp;

        $dayTimestamp = strtotime(date("Y-m-d",$now));
        $weekTimestamp = strtotime(date('Y-m-d',($now-((date('w',$now)==0?7:date('w',$now))-1)*24*3600)));
        $monthTimestamp = strtotime(date("Y-m-1",$now));
        //日活
        \Yii::$app->redis->setbit($this->buildDailyStatKey($dayTimestamp),$userId,1);
        \Yii::$app->redis->expire($this->buildDailyStatKey($dayTimestamp),self::DAY * 32);
        //月活和周活根据日活记录
        //周活
//        \Yii::$app->redis->setbit("wau_".$weekTimestamp,$userId,1);

        //月活
//        \Yii::$app->redis->setbit("mau_".$monthTimestamp,$userId,1);
    }

    /*
     *
     * */
    public function setCommentCount($now,$userId,$action = 1){

        $dayTimestamp = strtotime(date("Y-m-d",$now));
        //每日多少人评论了电影
        \Yii::$app->redis->setbit("comment_d_".$dayTimestamp,$userId,$action);
        \Yii::$app->redis->expire("comment_d_".$dayTimestamp,self::DAY * 32);

    }

    /*
     * 电影斩标记电影统计
     * */
    public function zhanUserChoiceCount($now,$choice,$userId,$action = 1){

        $dayTimestamp = strtotime(date("Y-m-d",$now));

        //每日有多少人甩电影斩标记了电影
        \Yii::$app->redis->setbit("zhan_d_".$choice.'_'.$dayTimestamp,$userId,$action);
        \Yii::$app->redis->expire("zhan_d_".$choice.'_'.$dayTimestamp,self::DAY * 32);

    }


    public function buildDailyStatChoiceZhan($dayTimestamp,$type){

        return "zhan_d_".$type.'_'.$dayTimestamp;
    }
    public function buildDailyStatKey($dayTimestamp){

        return "dau_".$dayTimestamp;
    }

    public function buildDailyCommentKey($dayTimestamp){

        return "comment_d_".$dayTimestamp;
    }

    public function getDailyCountStr($timestamp){

        return \Yii::$app->redis->get($this->buildDailyStatKey($timestamp));

    }
    public function getDailyCount($timestamp){

        return \Yii::$app->redis->bitcount($this->buildDailyStatKey($timestamp));

    }

    public function getDailyCommentCountStr($timestamp){

        return \Yii::$app->redis->get($this->buildDailyCommentKey($timestamp));

    }
    public function getDailyCommentCount($timestamp){

        return \Yii::$app->redis->bitcount($this->buildDailyCommentKey($timestamp));

    }

}