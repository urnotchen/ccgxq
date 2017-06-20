<?php

namespace frontend\modules\v1\models;


class FilmSynopsis extends \frontend\models\FilmSynopsis
{

    public function fields()
    {
        return [
            'source',
            'content' => function($model){
                if($model->content){
                    return str_replace(array('                                　　','                                    ','                        '), '', str_replace(array("\r\n", "\r", "\n","\t"), '', $model->content ));
                }
                return $model->content?strip_tags($model->content):null;
            },
        ];
    }

    public static function getOneTypeSynopsis($source){

        $model = self::findOne(['source' =>$source]);
        return  $model?strip_tags($model->content):null;

    }
}
