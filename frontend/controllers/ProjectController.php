<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Project;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * NoticeController implements the CRUD actions for Notice model.
 */
class ProjectController extends Controller
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


    public function actionProjectList($id)
    {
        return $this->renderPartial('project-list', [
            'projects' => Project::getProjectsByCategoryId($id),
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
