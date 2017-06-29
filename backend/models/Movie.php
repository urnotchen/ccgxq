<?php

namespace backend\models;

use backend\models\FilmChoiceUser;
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
                ->groupBy(self::tableName().'.id')->column();

        return $res;
    }
}

?>