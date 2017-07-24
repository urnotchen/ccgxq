<?php

namespace backend\models;


class Movie extends \common\models\Movie
{

    /*
    * 获取已经有资源用户待推送的电影名列表
    * */
    public static function getWaitPushMovieNameList($userId){


        $res = self::find()->select('title')
                ->join('join',MovieOnlineResource::tableName(),MovieOnlineResource::tableName().'.movie_id = '.self::tableName().'.id')
                ->join('join',FilmChoiceUser::tableName(),FilmChoiceUser::tableName().'.movie_id='.self::tableName().'.id' )
                ->where([FilmChoiceUser::tableName().'.user_id' => $userId,FilmChoiceUser::tableName().'.type' => FilmChoiceUser::TYPE_SUBSCRIBE,FilmChoiceUser::tableName().'.status' => FilmChoiceUser::STATUS_NORMAL,FilmChoiceUser::tableName().'.push' => FilmChoiceUser::PUSH_NO])
                ->andWhere(['between',MovieOnlineResource::tableName().'.created_at',time() - 86400 ,time()])
                ->groupBy(self::tableName().'.id')->column();

        return $res;
    }

    /*
     * 获取这三个月上映的新片 , 按上映的星期几获取
     * */
    public static function getMoiveIdsBy3Months($timestamp){

        $weekDay = date("w",$timestamp);

        return self::find()->select('id')
            ->where(['>=','release_timestamp', $timestamp - 3 * 30 * 86400])
            ->andWhere("from_unixtime(release_timestamp,'%w') = {$weekDay}")
            ->column();
    }
}

?>