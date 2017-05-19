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
use frontend\modules\v1\models\forms\MovieDetailsForm;
use yii\data\ActiveDataProvider;

class CommentController extends Controller{


    public function verbs()
    {
        return [
            'index'    => ['get'],
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
}