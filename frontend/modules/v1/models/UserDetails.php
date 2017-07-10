<?php

namespace frontend\modules\v1\models;


class UserDetails extends \frontend\models\UserDetails
{
    use \common\traits\ModelPrepareTrait;
    use \common\traits\SaveExceptionTrait;

    public function fields()
    {
        return [
            'nickname',
            'avatar' => function($model){
                if(strpos($model->avatar,'http://') === 0){
                    return $model->avatar;
                }
                return \Yii::$app->params['qiniuDomain'].$model->avatar;

            },
            'gender',
            'birth',
            'address',
            'career'
        ];
    }
}

?>