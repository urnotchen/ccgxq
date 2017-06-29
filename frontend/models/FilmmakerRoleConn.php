<?php

namespace frontend\models;

use frontend\modules\v1\models\Filmmaker;

class FilmmakerRoleConn extends \common\models\FilmmakerRoleConn
{

    public function fields()
    {
        return [
            'filmmaker_id' => function($model){
                return (int)$model->filmmaker_id;
            },
            'role_id',
            'name' => function($model){
                $nameList = explode(' ',$model->filmmakers->name,2);
                return $nameList?$nameList[0]:null;
            },
            'image' => function($model){
                return $model->filmmakers?\Yii::$app->params['qiniuDomain'].$model->filmmakers->image->path:null;
            }
        ];
    }
    public function getFilmmakers(){

        return $this->hasOne(Filmmaker::className(),['id' => 'filmmaker_id']);

    }
}
