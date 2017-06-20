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

        foreach($arr['definition'] as $eachDefinition) {

            $res = self::findOne(['movie_id' => $arr['movie_id'], 'definition' => $eachDefinition]);

            if (!$res) {
                $record = new self;
                $record->movie_id = $arr['movie_id'];
                $record->definition = $eachDefinition;
                $record->save();
            }
        }
    }
}