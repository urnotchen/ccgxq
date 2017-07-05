<?php

namespace backend\controllers;
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
                        'actions' => ['logout', 'index'],
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

    public function actionTest(){
//        echo MovieIndex::find()->join('left join',MovieDisk::tableName(),['movie_index.id' => 'movie_disk.movie_id'])
//            ->join('join','movie_link',['movie_link.movie_id' => 'movie_index.id'])->createCommand()->getRawSql();

//        $res = \Yii::$app->db->createCommand(MovieDisk::find()->select(['movie_index.*','movie_disk.*'])->join('join',MovieIndex::tableName(),MovieDisk::tableName().'.movie_id='. MovieIndex::tableName().'.id')->createCommand()->getRawSql())->queryAll();
//        var_dump($res);
//        echo $res = MovieDisk::find()->select('movie_index.*,movie_disk.*')->join('join',MovieIndex::tableName(),MovieDisk::tableName().'.movie_id='. MovieIndex::tableName().'.id')->createCommand()->getRawSql();

//        $weibo->posted_at >= time() - 6 * 60 * 60

        var_dump(\Yii::$app->JPush->send());

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
