<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\Misc;

class MiscController extends \frontend\components\rest\Controller
{
    public function verbs()
    {
        return [
            'policy'             => ['get'],
        ];
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function actionPolicy()
    {
        \Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_HTML;

        return Misc::find()->one()->policy;
    }
}

?>