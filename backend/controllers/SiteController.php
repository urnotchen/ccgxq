<?php

namespace backend\controllers;
use backend\models\FilmChoiceUser;
use Yii;
use backend\models\forms\LoginForm;

/**
 * Class SiteController
 * @package backend\controllers
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?','@'],
                    ],
                    [
                        'actions' => ['logout', 'index','test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('/project/project-category/index');
        return $this->render('index');
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTest(){phpinfo();
}

    public function actionLogin()
    {/*{{{*/

        Yii::$app->getUser()->setReturnUrl(Yii::$app->getRequest()->get('return_url', ['/site/index']));

        if (!\Yii::$app->user->isGuest) {
            $this->goBack();
        }

        $model = new LoginForm;

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);

    }/*}}}*/
}
