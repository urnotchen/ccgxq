<?php

namespace backend\modules\movie\controllers;

use yii\data\ActiveDataProvider;

use backend\modules\movie\models\Movie;
use backend\modules\movie\models\MovieResource;
use backend\modules\movie\models\OnlineResource;


class MovieController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'footprint' => [
                'class' => \bluelive\components\FootprintBehavior::className(),
                'enableAction' => [
                    'index'
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Movie::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $rawParams = \Yii::$app->request->post();

        $model = new Movie;
        $movieResource = new MovieResource;
        $onlineResource = new OnlineResource;

        if ($model->load($rawParams) && $model->save()) {
            $movieResource->movie_id = $onlineResource->movie_id = $model->id;

            if (
                $movieResource->load($rawParams) && $movieResource->save() &&
                $onlineResource->load($rawParams) && $onlineResource->save()
            ) {

                return $this->redirect('index');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'movieResource' => $movieResource,
            'onlineResource' => $onlineResource
        ]);
    }

    public function actionUpdate($id)
    {
        $rawParams = \Yii::$app->request->post();

        $model = Movie::findOneOrException(['id' => $id]);
        $movieResource = $model->movieResource;
        $onlineResource = $model->onlineResource;

        if (
            $model->load($rawParams) && $model->save() &&
            $movieResource->load($rawParams) && $movieResource->save() &&
            $onlineResource->load($rawParams) && $onlineResource->save()
        ) {

            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'movieResource' => $movieResource,
            'onlineResource' => $onlineResource
        ]);
    }

    public function actionView($id)
    {
        $model = Movie::findOneOrException(['id' => $id]);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        Movie::findOneOrException(['id' => $id])->delete();

        return $this->redirect('index');
    }
}

?>