<?php

namespace frontend\components\rest;
use common\models\User;

/**
 * frontend 所有的 controller 都继承自本controller
 * 
 * 用于将所有接口返回的数据转换成json格式
 */
class Controller extends \yii\rest\Controller
{
    //重写$serializer
    public $serializer = 'frontend\components\rest\Serializer';

    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['contentNegotiator']['formats']['application/xml'] = \yii\web\Response::FORMAT_JSON;
        $inherit['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_HTML;

        return $inherit;
    }

    /**
     * @return null|\yii\web\IdentityInterface|\frontend\models\User
     */
    protected function getUser()
    {
        $user =  \Yii::$app->user->identity;
        User::updateLastUseTime($user->id);
        return $user;
    }
}
