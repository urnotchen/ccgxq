<?php

namespace backend\modules\order\controllers;

use backend\modules\order\actions\Upload;
use backend\modules\order\models\form\OrderForm;
use backend\modules\order\models\User;
use Yii;
use backend\modules\order\models\Order;
use backend\modules\order\models\search\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
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

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'position_kv' => Order::enum('position'),
                'work_time_kv' => Order::enum('work_time'),
                'model' => $model,
            ]);
        }
    }

    public function actionBook(){

    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'position_kv' => Order::enum('position'),
                'work_time_kv' => Order::enum('work_time'),
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 编辑框异步上传图片
     *
     * @return array
     */
    public function actions() {
        return [
            'upload' => [
                'class' => Upload::className(),
                'uploadBasePath' => '@webroot', //file system path ps:当前运行应用的 Web 入口目录
                'uploadBaseUrl' => '@web', //web path @web ps:当前运行应用的根 URL
                'csrf' => true, //csrf校验

                'configPatch' => [
                    'imageMaxSize' =>  2 * 1024 * 1024, //图片
                    'scrawlMaxSize' => 500 * 1024, //涂鸦
                    'catcherMaxSize' => 500 * 1024, //远程
                    'videoMaxSize' => 1024 * 1024, //视频
                    'fileMaxSize' => 1024 * 1024, //文件
                    'imageManagerListPath' => '/', //图片列表
                    'fileManagerListPath' => '/', //文件列表
                ],

                // OR Closure
                'pathFormat' => [
                    'imagePathFormat' => '/uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'scrawlPathFormat' => '/uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'snapscreenPathFormat' => '/uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'catcherPathFormat' => '/uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'videoPathFormat' => '/uploads/videos/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'filePathFormat' => '/uploads/files/{yyyy}{mm}{dd}/{time}{rand:6}',
                ],
                'configPatch' => [
                    'imageManagerListPath' => 'uploads/images', //图片列表
                    'fileManagerListPath' => 'uploads/images', //文件列表
                ],

                'beforeUpload' => function($action) {
                    //throw new \yii\base\Exception('error message'); //break
                },
                'afterUpload' => function($action) {
                    /*@var $action \xj\ueditor\actions\Upload */

                    $result = $action->result;
//                    复制文件到前台
                    if(!is_dir('../../frontend/web/uploads/images/'.date("Ymd"))){
                        mkdir('../../frontend/web/uploads/images/'.date("Ymd"),0777);
                    }
                    $res = copy(Yii::getAlias('@webroot').$result['url'],'../../frontend/web/uploads/images/'.date("Ymd").'/'.$result['title']);
                    if(!$res){
                        echo '上传失败';
                    }
                },
            ],
        ];
    }
}
