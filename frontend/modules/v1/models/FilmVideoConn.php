<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/4/26
 * Time: 15:14
 */
namespace frontend\modules\v1\models;

class FilmVideoConn extends \frontend\models\FilmVideoConn{

    public function fields()
    {
        return [
            'id',
            'website' => function($model){
                return $model->website->id;
            },
            'url',
        ];
    }

    public function extraFields()
    {
        return [
            'onlineResource' => function($model) {
                return $model->movie->movieOnlineResource?$model->movie->movieOnlineResource:null;

            },
        ];

    }


}