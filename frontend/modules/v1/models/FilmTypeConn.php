<?php

namespace frontend\modules\v1\models;


class FilmTypeConn extends \frontend\models\FilmTypeConn
{

    public static function getType($movieId){
        return self::find()->select('type_id')->where(['movie_id' => $movieId])->column();
    }
}

