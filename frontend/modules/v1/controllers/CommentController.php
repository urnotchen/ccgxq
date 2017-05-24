<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/18
 * Time: 16:50
 */

namespace frontend\modules\v1\controllers;

use frontend\components\rest\Controller;
use frontend\modules\v1\models\FilmComment;
use frontend\modules\v1\models\forms\FilmCommentForm;
use frontend\modules\v1\models\forms\MovieDetailsForm;
use yii\data\ActiveDataProvider;

class CommentController extends Controller{


    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['only'] = [
            'index','permit-comment','create-comment',
        ];
        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];



        return $inherit;
    }
    public function verbs()
    {
        return [
            'index'    => ['get'],
            'permit-comment'    => ['get'],
            'create-comment'    => ['get'],
        ];
    }

    /*
     * 评论列表
     * */
    public function actionIndex(){

        $rawParams = \Yii::$app->getRequest()->get();

        $form = new MovieDetailsForm();
        $movie = $form->prepare($rawParams);
        return new ActiveDataProvider([
            'query' => FilmComment::find()->where(['movie_id' => $movie->id])->typeSequence()->goodNumSequence(),
            'pagination' => [
                'defaultPageSize' => 10,
            ],
        ]);
    }

    /*
     * 是否允许添加评论
     * */
    public function actionPermitComment(){

        $rawParams = \Yii::$app->getRequest()->get();
        $form = new FilmCommentForm();
        $form->prepare($rawParams);

        return FilmComment::permitComment($rawParams['movie_id'],$this->getUser()->id);

    }


    /*
     * 添加评论
     *
     * */
    public function  actionCreateComment(){

        $rawParams = \Yii::$app->getRequest()->get();
        $form = new FilmCommentForm();
        $comment = $form->prepare($rawParams);
        return FilmComment::addComment($comment,$this->getUser()->id);
    }
}