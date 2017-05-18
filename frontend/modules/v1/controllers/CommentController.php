<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/18
 * Time: 16:50
 */

namespace frontend\modules\v1\controllers;

use frontend\components\rest\Controller;
use frontend\modules\v1\models\forms\MovieDetailsForm;

class CommentController extends Controller{


    public function verbs()
    {
        return [
            'video-index'    => ['get'],
        ];
    }

    public function actionIndex(){

        $rawParams = \Yii::$app->getRequest()->get();

        $form = new MovieDetailsForm();
        $movie = $form->prepare($rawParams);

        return $movie;
    }
}