<?php

namespace frontend\controllers;

use frontend\models\forms\LoginForm;
use frontend\models\forms\RegisterForm;
use frontend\models\FrontUser;
use frontend\models\Notice;
use frontend\models\ProjectCategory;
use Yii;


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
                        'actions' => ['logout', 'index','login','test','indexx','register'],
                        'allow' => true,
                        'roles' => ['?','@'],
                    ],
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
    public function actionIndexx()
    {


        $notices = \frontend\models\Notice::getNotices(Notice::CATE_NOTICE);
        return $this->render('index2', [
            'notices' => $notices,
            'personal_project' => ProjectCategory::getPersonalCategories(),
            'company_project' => ProjectCategory::getCompanyCategories(),
        ]);

    }
    public function actionIndex()
        {


            $notices = \frontend\models\Notice::getNotices(Notice::CATE_NOTICE,$keyword = null,6);
            return $this->renderPartial('index', [
                'notices' => $notices,
                'personal_project' => ProjectCategory::getPersonalCategories(),
                'company_project' => ProjectCategory::getCompanyCategories(),
            ]);

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
    public function actionLogin(){


//        Yii::$app->getUser()->setReturnUrl(Yii::$app->getRequest()->get('return_url', ['/site/index']));
//
//        if (!\Yii::$app->user->isGuest) {
//            $this->goBack();
//        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {


            $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionRegister(){


        Yii::$app->getUser()->setReturnUrl(Yii::$app->getRequest()->get('return_url', ['/site/index']));

        if (!\Yii::$app->user->isGuest) {
            $this->goBack();
        }

        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())&& $model->save() ) {
            $this->redirect('site/index');
        }

        return $this->render('register', [
            'title' => '注册',
            'certificates_type_kv' => FrontUser::enum('certificates_type'),
            'model' => $model,
        ]);
    }

}
