<?php

namespace frontend\models;

use common\helper\MovieHelper;
use frontend\modules\v1\models\Filmmaker;

class FilmmakerRoleConn extends \common\models\FilmmakerRoleConn
{

    public $movieHelper;
    public function fields()
    {
        return [
            'filmmaker_id' => function($model){
                return (int)$model->filmmaker_id;
            },
            'role_id',
            'name' => function($model) {
                if($model->filmmakers){
                    $titleList = explode(' ',$model->filmmakers->name,2);

                    return $titleList?$titleList[0]:'';
                }
                return null;
            },
            'image' => function($model){
                return $model->filmmakers?$model->filmmakers->image?\Yii::$app->params['qiniuDomain'].$model->filmmakers->image->path:null:null;
            }
        ];
    }
    public function getFilmmakers(){

        return $this->hasOne(Filmmaker::className(),['id' => 'filmmaker_id']);

    }
}
