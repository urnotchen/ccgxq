<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\Misc;

class MiscController extends \frontend\components\rest\Controller
{
    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['only'] = [
            'qiniu-info',
        ];
        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];



        return $inherit;
    }
    public function verbs()
    {
        return [
            'policy'             => ['get'],
            'qiniu-info'             => ['get'],
        ];
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function actionPolicy()
    {
        \Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_HTML;

        return Misc::getPolicyInfo();
    }

    public function actionQiniuInfo(){

        return json_decode(Misc::getQiniuInfo());
    }
}

?>