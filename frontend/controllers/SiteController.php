<?php

namespace frontend\controllers;

/**
 * Site controller
 */
class SiteController extends \frontend\components\rest\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'api-error' => [
                'class' => 'frontend\components\rest\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {

        return 'hello and welcome. your IP: ' . \Yii::$app->request->userIP;
    }
}
