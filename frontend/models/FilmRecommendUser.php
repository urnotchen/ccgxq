<?php

namespace frontend\models;


class FilmRecommendUser extends \common\models\FilmRecommendUser
{
    /*
     * 判断是否已经给用户推荐过电影斩(间接判断是不是第一次进入电影斩)
     * */
    public static function yetRecommend($userId){

        return self::findOne(['user_id' => $userId,'type' => self::TYPE_OFFICIAL])?True:False;
//        return self::findOne(['user_id' => $user_id,'movie_id' => FilmProperty::getRecommendOfficialIds()])?True:False;

    }

    /*
     * 获取已经给用户推荐了的电影列表
     *
     * */
//    public static function getRecommendedMovieIds($userId){
//
//        return self::find()->select('movie_id')
//            ->where(['user_id' => $userId,'choice' => [self::CHOICE_SAW,self::CHOICE_COLLECT,self::CHOICE_PASS]])->column();
//    }
    /*
     * 获取用户已经生成的电影id列表
     * 不论状态,只要在film_recommend_user中就可以
     * */
    public static function getUserAllMovieIds($userId){

        return self::find()->select('movie_id')->where(['user_id' => $userId])->column();
    }


}
