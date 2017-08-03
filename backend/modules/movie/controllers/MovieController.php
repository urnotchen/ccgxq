<?php

namespace backend\modules\movie\controllers;

use backend\modules\movie\models\FilmVideoWebsite;
use backend\modules\movie\models\Image;
use backend\modules\movie\models\ScrapyUpdateProcess;
use backend\modules\movie\services\MovieListService;
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

    protected $_service;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete','test','recommend'],
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

    public function actionRecommend()
    {
        $searchModel = new MovieSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('recommend', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $rawParams = \Yii::$app->request->post();

        $model = new ScrapyUpdateProcess;

        if($model->load($rawParams)){
            $model->scrape_date = strtotime(date("Y-m-d"));
            $model->referer = 'https://movie.douban.com/';
            preg_match('/subject\/(\d+)\//',$model->movie_url,$arr);
            if(isset($arr[1])){
                $model->movie_id = $arr[1];
                if($model->save()){
                    \Yii::$app->getSession()->setFlash('success', ["添加成功"]);
                }else{
                    \Yii::$app->getSession()->setFlash('error', ["已有此电影"]);
                }
            }else{
                \Yii::$app->getSession()->setFlash('error', ["链接格式不正确"]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $rawParams = \Yii::$app->request->post();

        $model = Movie::findOneOrException(['id' => $id]);


//        $model->director = implode(',', Json::decode($model->director));
//        $model->actor = implode(',', Json::decode($model->actor));
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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

    public function actionTest(){//
        var_dump($this->service->zhanTest());
    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new MovieListService();
        }

        return $this->_service;
    }


}
?>