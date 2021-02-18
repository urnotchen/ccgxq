<?php

namespace frontend\controllers;

use frontend\models\forms\UploadForm;
use Yii;
use frontend\models\Approval;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * NoticeController implements the CRUD actions for Notice model.
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





    public function actionIndex($project_id)
    {

        return $this->renderPartial('index', [
            'backend_domain' => APP_DOMAIN_SCHEMA.APP_BACK_BASE_DOMAIN,
            'approval' => Approval::getApprovalByProjectId($project_id),
        ]);
    }


    public function actionView($id)
    {
        return $this->renderPartial('index', [
            'backend_domain' => APP_DOMAIN_SCHEMA.APP_BACK_BASE_DOMAIN,
            'approval' => Approval::getApprovalById($id),
        ]);
    }


    public function actionUpload($approval_id){

        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $approval_id = Yii::$app->request->post('UploadForm')['approval_id'];
            $label_arr = Yii::$app->request->post('UploadForm')['label_arr'];
//var_export($approval_id);
// var_export( Yii::$app->request->post('UploadForm'));die;
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            // var_export($model->imageFiles);die;
            $model->approval_id = $approval_id;
            $model->label_arr = $label_arr;
            if ( $model->upload()) {
                // var_dump($model);die;
                // 文件上传成功
                // var_dump($model);
                return $this->render('approval_ok');
            }else{

            }
        }

        $approval = $this->findModel($approval_id);

        $blclml = json_decode($approval['blclml']);
        $tmp = [];
        $label = [];
        foreach ($blclml as $one){

            $tmp[] = $one[1];
        }

        return $this->render('upload',[
            'model' => $model,
            'tmp' => $tmp,
            'approval_id' => $approval_id,
            'label_arr' => serialize($tmp),
        ]);
    }


    /**
     * Finds the Partment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Partment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = \frontend\models\Approval::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
