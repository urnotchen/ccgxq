<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/18
 * Time: 16:50
 */

namespace frontend\modules\v1\controllers;

use frontend\components\rest\Controller;
use frontend\modules\v1\helpers\QueryHelper;
use frontend\modules\v1\models\CommentZan;
use frontend\modules\v1\models\FilmComment;
use frontend\modules\v1\models\forms\CommentZanForm;
use frontend\modules\v1\models\forms\FilmCommentForm;
use frontend\modules\v1\models\forms\FilmCommentIndexForm;
use frontend\modules\v1\models\forms\FilmCommentTimeline;
use frontend\modules\v1\models\forms\MovieDetailsForm;
use frontend\modules\v1\models\User;
use yii\data\ActiveDataProvider;

class CommentController extends Controller{


    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['only'] = [
            'index','create-comment','zan','num'
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
            'create-comment'    => ['post'],
            'zan'    => ['post'],
            'num'    => ['get'],
        ];
    }

    /*
     * 评论列表
     * */
    public function actionIndex(){

        $rawParams = \Yii::$app->getRequest()->get();

        $form = new FilmCommentIndexForm();
        $form->prepare($rawParams);
        $this->getUser();
        return FilmCommentTimeline::timeline($rawParams,QueryHelper::executeMultiTimelineQuery(FilmComment::getCommentListQuery($form->movie_id)));

    }

    /*
     * 是否允许添加评论
     * 废弃
     * */
//    public function actionPermitComment(){
//
//        $rawParams = \Yii::$app->getRequest()->get();
//        $form = new FilmCommentForm();
//        $form->prepare($rawParams);
//
//        return FilmComment::permitComment($rawParams['movie_id'],$this->getUser()->id);
//
//    }


    /*
     * 添加评论
     *
     * */
    public function  actionCreateComment(){

        $rawParams = \Yii::$app->getRequest()->post();
        $form = new FilmCommentForm();
        $comment = $form->prepare($rawParams);
        return FilmComment::addComment($comment,$this->getUser()->id);
    }

    /*
     * 点赞
     *
     * */
    public function actionZan(){

        $rawParams = \Yii::$app->getRequest()->post();
        $form = new CommentZanForm();
        $form->prepare($rawParams);
        $this->getUser();
        return CommentZan::zan($form->id,$form->action);
    }

    /*
     * 电影评论总数
     * */
    public function actionNum(){
        $rawParams = \Yii::$app->getRequest()->get();

        $form = new MovieDetailsForm();

        $form->prepare($rawParams);

        $this->getUser();

        return ['num' => FilmComment::getCommentNum($form->id)];
    }
}