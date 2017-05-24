<?php

namespace frontend\models;

use frontend\modules\v1\models\FilmProperty;

class FilmRecommendUser extends \common\models\FilmRecommendUser
{
    /*
     * 判断是否已经给用户推荐过电影斩(间接判断是不是第一次进入电影斩)
     * */
    public static function yetRecommend($user_id){

        return self::findOne(['user_id' => $user_id,'movie_id' => FilmProperty::getRecommendOfficialIds()])?True:False;

    }
}
