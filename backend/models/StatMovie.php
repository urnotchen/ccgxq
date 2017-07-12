<?php

namespace backend\models;

class StatMovie extends \common\models\StatMovie
{

    public static function addRecord($day,$type,$movie_id,$num){

        $record = new self;

        $record->day = $day;
        $record->type = $type;
        $record->movie_id = $movie_id;
        $record->num = $num;

        $record->save();
    }
}
