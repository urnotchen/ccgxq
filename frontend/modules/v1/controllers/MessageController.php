<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\forms\MessageTimeline;
use frontend\modules\v1\models\forms\MessageYetReadForm;
use frontend\modules\v1\models\forms\MovieDetailsForm;
use frontend\modules\v1\models\forms\MovieListForm;
use frontend\modules\v1\models\forms\UserChoiceListForm;
use frontend\modules\v1\models\Message;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\services\MovieListService;
use Yii;
use yii\data\ActiveDataProvider;



class MessageController extends \frontend\components\rest\Controller
{

    protected $_service;

    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['only'] = [
            'index','yer-read','resource-remind'
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
            'resource-remind' => ['get'],
            'yet-read'    => ['post'],
        ];
    }

    public function actionIndex()
    {

        $rawParams = Yii::$app->getRequest()->get();

        return MessageTimeline::timeline($rawParams,['user_id' => Yii::$app->getUser()->id]);
    }


    public function actionYetRead(){

        $rawParams = Yii::$app->getRequest()->post();

        $form = new MessageYetReadForm();
        $form->prepare($rawParams);
        return Message::toYetRead($form->id);

    }

    public function actionResourceRemind(){

        $this->getUser();
        return False;
    }

}

?>