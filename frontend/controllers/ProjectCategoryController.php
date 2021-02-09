<?php

namespace frontend\controllers;


use frontend\models\ProjectCategory;
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * NoticeController implements the CRUD actions for Notice model.
 */
class ProjectCategoryController extends Controller
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionPersonalIndex($keyword = null)
    {
        return $this->renderPartial('personal-index', [
            'personal_project' => ProjectCategory::getPersonalCategories($keyword),
        ]);
    }

    public function actionCompanyIndex($keyword = null)
    {
        return $this->renderPartial('company-index', [
            'company_project' => ProjectCategory::getCompanyCategories($keyword),
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
        if (($model = \frontend\models\ProjectCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
