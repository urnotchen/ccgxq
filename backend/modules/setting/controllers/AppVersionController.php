<?php

namespace backend\modules\setting\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\setting\models\AppVersion;
use backend\modules\setting\models\searches\AppVersionSearch;

/**
 * AppVersionController implements the CRUD actions for AppVersion model.
 */
class AppVersionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'shortcut'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'footprint' => [
                'class' => \bluelive\components\FootprintBehavior::className(),
                'enableAction' => [
                    'policy', 'create', 'update'
                ],
            ],
        ];
    }

    /**
     * Lists all AppVersion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppVersionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AppVersion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppVersion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AppVersion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionShortcut($id)
    {
        $model = AppVersion::findOneOrException(['id' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return true;
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

}
