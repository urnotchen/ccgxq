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
                    $content = strip_tags($model->content);
                    return  trim(preg_replace("/\n+/", "\n", str_replace(array('                                　　','                                    ','                        '), '', strip_tags($content ))));
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
