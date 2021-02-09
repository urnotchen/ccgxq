<?php

namespace backend\modules\comm\controllers;

use backend\helper\UeditorUpload;
use backend\modules\comm\actions\Upload;
use backend\modules\comm\models\User;
use common\models\search\EmailSearch;
use Yii;
use common\models\Email;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmailController implements the CRUD actions for Email model.
 */
class EmailController extends Controller
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
     * Lists all Email models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'user_kv' => User::kv('id','real_name'),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Email model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'user_kv' => User::kv('id','real_name'),
        ]);
    }

    /**
     * Creates a new Email model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($eid=null)
    {

        $model = new Email();
        if($eid){
            $model->eid = $eid;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'user_kv' => User::kv('id','real_name'),
            ]);
        }
    }
    /*
     * 回复邮件
     *
     * */

    public function actionReply($eid)
    {

        $model = new Email();
        $ori_email = $this->findModel($eid);
        if($eid){
            $model->eid = $eid;
            $model->sendto = $ori_email->created_by;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'user_kv' => User::kv('id','real_name'),
            ]);
        }
    }

    /**
     * Updates an existing Email model.
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
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Email model.
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
     * Finds the Email model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Email the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Email::findOne($id)) !== null) {
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


                },
            ],
        ];
    }

}
