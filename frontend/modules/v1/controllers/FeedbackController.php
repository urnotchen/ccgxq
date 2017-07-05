<?php

namespace frontend\modules\v1\controllers;

use Yii;

class FeedbackController extends \frontend\components\rest\Controller
{
    protected $_service;

    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];

        return $inherit;
    }

    public function verbs()
    {
        return [
            'post-feedback'          => ['post'],
            'get-feedback'           => ['get'],
        ];
    }

    public function actionPostFeedback()
    {
        $rawParams = Yii::$app->getRequest()->post();

        return $this->getService()->postFeedback($rawParams);
    }

    public function actionGetFeedback()
    {
        $rawParams = Yii::$app->getRequest()->get();

        return $this->getService()->getFeedback($rawParams);
    }

    protected function getService()
    {
        if ($this->_service === null) {

            $this->_service = new \frontend\modules\v1\services\FeedbackService();
        }

        return $this->_service;
    }
}


?>