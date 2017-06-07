<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/26
 * Time: 14:22
 */
namespace frontend\modules\v1\helpers;
use yii\db\Expression;
use frontend\modules\v1\models\Movie;

class QueryHelper {

    public static function executeMultiTimelineQuery($query){

        //获取电影列表的query
        $query =  $query->createCommand()->getRawSql();
        $query2 = new \common\models\queries\Query(Movie::className());
        //生成列idTemp
        $query2->select(new Expression("@rownum := @rownum +1 as idTemp,t.*"))->from(new Expression("({$query} )as t"));
        $query2 = $query2->createCommand()->getRawSql();

        return $query2;

    }
}