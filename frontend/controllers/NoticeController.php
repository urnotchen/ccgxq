<?php

namespace frontend\controllers;


use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\setting\models\User;
use backend\modules\setting\models\Notice;
/**
 * NoticeController implements the CRUD actions for Notice model.
 */
class NoticeController extends Controller
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




    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->renderPartial('view', [
            'model' => $model,
            'name' => Notice::enum('cate_id')[$model->cate_id],
        ]);
    }


    public function actionIndex($cate_id,$keyword = null)
    {
        return $this->renderPartial('index', [
            'list' => \frontend\models\Notice::getNotices($cate_id,$keyword),
            'name' => Notice::enum('cate_id')[$cate_id],
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
        if (($model = \frontend\models\Notice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
