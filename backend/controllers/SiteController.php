<?php

namespace backend\controllers;

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
                        'actions' => ['error','test'],
                        'allow' => true,
                        'roles' => ['@'],
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
        $tables = "(SELECT `movie`.*, (select @rownum:=0) FROM `movie` join `movie_index` ON movie.id=movie_index.douban left join `film_property` ON movie.id=film_property.movie_id WHERE (`property`=1) OR (`property` IS NULL) ORDER BY `film_property`.`sequence` DESC, `film_property`.`created_at` DESC, `movie_index`.`create_at` DESC, `movie`.`release_timestamp` DESC )as t";
        file_put_contents("D:/phpStudy/weixinLog/". date('Ymd') ."elog.txt",time() ." ". date("m-d H:i:s")
            .'//$将 raw html 处理成 Array $essay_list 文章sn一致= '. $tables."\r\n\r\n",FILE_APPEND);
        $tables = preg_split('/\s*,\s*order/', trim($tables), -1, PREG_SPLIT_NO_EMPTY);
        echo "<pre>";
        var_export($tables);
        echo "</pre>";
    }
}
