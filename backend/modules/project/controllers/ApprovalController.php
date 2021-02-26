<?php

namespace backend\modules\project\controllers;

use backend\modules\comm\actions\Upload;
use backend\modules\project\models\Project;
use backend\modules\setting\actions\Uploader;
use Yii;
use backend\modules\project\models\Approval;
use backend\modules\project\models\search\ApprovalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\UploadedFile;

/**
 * ApprovalController implements the CRUD actions for Approval model.
 */
class ApprovalController extends Controller
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
     * Lists all Approval models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApprovalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Approval model.
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
     * Creates a new Approval model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Approval();




//        $file = UploadedFile::getInstancesByName('avatar');
//        $file->saveAs(Yii::getAlias("@webroot").'/data/test.jpg');


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $this->layout = 'empty';
            return $this->render('create', [
                'blclml' => [],
                'project_kv' => Project::getProjectKv(),
                'model' => $model,
            ]);
        }
    }

    //todo 封装成upload 并验证
    public $separator  = '.';
    public function getExt($url)
     {
     $path=parse_url($url);
     $str=explode('.',$path['path']);
     return $str[1];
     }

    public function actionUploadImage(){


        $src_file =$_FILES["file"]["tmp_name"];
        $Ymd= date("Ymd");
        $dir = rtrim(Yii::getAlias('@webroot/uploads'))."/images/".$Ymd;
        if(!$dir){
            mkdir($dir,0777);
        }
        $file_name = '/uploads/images/'.$Ymd.'/'.time().rand(1111,9999).$this->separator.$this->getExt($_FILES["file"]["name"]);
        $uploadfile = rtrim(Yii::getAlias('@webroot')).$file_name;

        if(move_uploaded_file($src_file,$uploadfile)){
            return $file_name;
        }

        return false;
    }
    /**
     * Updates an existing Approval model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $tmp = json_decode($model->blclml);
            $blclml = [];
            foreach ($tmp as  $value){
                $value[6] = '<a class="edit" href="">编辑</a>';
                $value[7] = '<a class="delete" href="">删除</a>';
                $blclml[] = $value;
            }

            return $this->render('update', [
                'project_kv' => Project::getProjectKv(),
                'blclml' => json_encode($blclml),
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Approval model.
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
     * Finds the Approval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Approval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Approval::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
