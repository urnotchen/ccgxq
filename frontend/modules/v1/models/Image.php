<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/15
 * Time: 16:01
 */

namespace frontend\modules\v1\models;

class Image extends \frontend\models\Image{

    public function fields()
    {
        return [
            'url' => function($model){
                return $model->path?\Yii::$app->params['qiniuDomain'].$model->path:'';
            }
        ];
    }

}