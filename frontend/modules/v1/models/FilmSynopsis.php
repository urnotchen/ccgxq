<?php

namespace frontend\modules\v1\models;


class FilmSynopsis extends \frontend\models\FilmSynopsis
{

    public function fields()
    {
        return [
            'source',
            'content' => function($model){
                return strip_tags($model->content);
            },
        ];
    }

    public static function getOneTypeSynopsis($source){

        $model = self::findOne(['source' =>$source]);
        return  $model?strip_tags($model->content):null;

    }
}
