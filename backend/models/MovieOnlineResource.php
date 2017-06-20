<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/19
 * Time: 17:52
 */

namespace backend\models;

class MovieOnlineResource extends \common\models\MovieOnlineResource{

    public static function record($arr){

        $res = self::findOne(['movie_id' => $arr['movie_id'],'definition' => $arr['definition']]);

        if(!$res){
            $record = new self;
            $record->movie_id = $arr['movie_id'];
            $record->definition = $arr['definition'];
            $record->save();
        }
    }
}