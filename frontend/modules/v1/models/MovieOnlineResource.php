<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/29
 * Time: 9:41
 */

namespace  frontend\modules\v1\models;

class MovieOnlineResource extends \frontend\models\MovieOnlineResource{

    public static function isOnlineResource($movie_id){

        return self::findOne(['movie_id' => $movie_id])?True:False;
    }
}