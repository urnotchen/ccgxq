<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/7/12
 * Time: 17:24
 */

namespace backend\modules\user\controllers;

use backend\modules\user\models\searches\UserDetailsSearch;
use yii\base\Controller;
use yii\filters\VerbFilter;
use Yii;


class UserDetailsController extends Controller{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex(){

        $searchModel = new UserDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}