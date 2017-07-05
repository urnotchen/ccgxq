<?php

namespace backend\modules\stat\controllers;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

use backend\modules\stat\models\StatDaily;

class StatController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'search'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'footprint' => [
                'class' => \bluelive\components\FootprintBehavior::className(),
                'enableAction' => [
                    'index', 'search'
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionSearch()
    {
        $rawParams = Yii::$app->request->queryParams;

        list($begin, $end) = Yii::$app->dateFormat
            ->convertDateRangeToTimestampRange(ArrayHelper::getValue($rawParams, 'date'));
        list($rangeDate, $rangeData) = StatDaily::getRangeStatDaily($begin, $end);

        return Json::encode(array_combine($rangeDate, $rangeData));
    }
}

?>