<?php

namespace backend\modules\movie\controllers;

use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\search\MovieSearch;
use backend\modules\movie\models\Movie;
use backend\modules\movie\models\MovieResource;
use backend\modules\movie\models\OnlineResource;
use backend\modules\movie\models\FilmProperty;

class MovieController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete','test'],
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
        $searchModel = new MovieSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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

        $model->director = implode(',', Json::decode($model->director));
        $model->actor = implode(',', Json::decode($model->actor));

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

    public function actionTest(){
//        $query = Movie::find();
//        $query->join('join',FilmProperty::tableName(),Movie::tableName().'.id='. FilmProperty::tableName().'.movie_id' )->andFilterWhere([FilmProperty::tableName().'.property' => 2]);
//
//        var_dump($query->createCommand()->getRawSql());
       $datetime1 = new \DateTime("@-713347200");
        $datetime1->setTimezone(new \DateTimeZone('PRC'));
        print( $datetime1->format("Y-m-d H:i:s"));
    }
}
?>