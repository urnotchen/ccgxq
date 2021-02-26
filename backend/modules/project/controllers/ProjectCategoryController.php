<?php

namespace backend\modules\project\controllers;

use backend\modules\project\models\Project;
use backend\modules\project\models\User;
use Yii;
use backend\modules\project\models\ProjectCategory;
use common\models\search\ProjectCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectCategoryController implements the CRUD actions for ProjectCategory model.
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

    /**
     * Lists all ProjectCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'user_kv' => User::getUserKv(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectCategory model.
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
     * Creates a new ProjectCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [

                'category_kv' => ProjectCategory::getCategoryKv(),
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectCategory model.
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
            return $this->render('update', [
                'category_kv' => ProjectCategory::getCategoryKv(),
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectCategory model.
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
     * Finds the ProjectCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
