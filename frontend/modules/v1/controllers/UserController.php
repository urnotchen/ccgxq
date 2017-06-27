<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\User;
use Yii;

class UserController extends \frontend\components\rest\Controller
{
    protected $_service;

    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['only'] = [
            'change-details', 'request-change-password', 'change-password', 'view', 'ping'
        ];
        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];

//        $inherit['online'] = [
//            'class' => \frontend\modules\v1\behaviors\OnlineBehavior::className(),
//            'only' => [
//                'change-details', 'request-change-password', 'change-password'
//            ]
//        ];

        return $inherit;
    }

    public function verbs()
    {
        return [
            'view'                    => ['get'],

            'register'                => ['post'],
            'login'                   => ['post'],
            'change-details'          => ['post'],
            'social-login'            => ['post'],
            'request-reset-password'  => ['post'],
            'reset-password'          => ['post'],
            'request-change-password' => ['post'],
            'change-password'         => ['post'],
            'validate-captcha'        => ['post'],
        ];
    }

    /**
     * @return \frontend\modules\v1\models\UserToken
     */
    public function actionRegister()
    {
        $rawParams = Yii::$app->getRequest()->post();

        return $this->getService()->registerViaBasic($rawParams);
    }

    /**
     * @return mixed
     */
    public function actionLogin()
    {
        $rawParams = Yii::$app->getRequest()->post();

        return $this->getService()->loginViaBasic($rawParams);
    }

    /**
     * @return null|\yii\web\IdentityInterface
     */
    public function actionView()
    {
        return \frontend\modules\v1\models\User::findOneOrException([
            'id' => $this->getUser()->id
        ]);
    }

    /**
     * @return object
     */
    public function actionChangeDetails()
    {
        $rawParams = Yii::$app->getRequest()->post();

        return $this->getService()->saveDetails($rawParams);
    }

    /**
     * @return object
     */
    public function actionSocialLogin()
    {
        $rawParams = Yii::$app->getRequest()->post();

        return $this->getService()->loginViaSocial($rawParams);
    }

    /**
     * @return mixed
     */
    public function actionRequestChangePassword()
    {
        $rawParams = Yii::$app->getRequest()->post();

        $form = new \frontend\modules\v1\models\forms\UserPasswordForm(['user' => $this->getUser()]);
        $form->prepare($rawParams);

        return ['token' => Yii::$app->passwordTokenCache->setToken($this->getUser())];

    }

    /**
     * @return mixed
     */
    public function actionChangePassword()
    {
        $rawParams = Yii::$app->getRequest()->post();

        $form = new \frontend\modules\v1\models\forms\UserChgPwdForm(['user' => $this->getUser()]);
        $form->prepare($rawParams);
        return $this->getUser()->changePassword($form->password);
    }

    /**
     * @return array
     */
    public function actionRequestResetPassword()
    {
        $rawParams = Yii::$app->getRequest()->post();

        return $this->getService()->sendRePwdCapt($rawParams);
    }

    /**
     * @return bool
     */
    public function actionValidateCaptcha()
    {
        $rawParams = Yii::$app->getRequest()->post();

        $form = new \frontend\modules\v1\models\forms\ValidateCaptchaForm();

        return $form->prepare($rawParams);
    }

    /**
     * @return bool
     */
    public function actionResetPassword()
    {
        $rawParams = Yii::$app->getRequest()->post();

        return $this->getService()->resetPassword($rawParams);
    }

    public function actionPing()
    {
        $rawParams = Yii::$app->getRequest()->post();

        return $this->getService()->heartbeat($rawParams);
    }

    /**
     * @return \frontend\modules\v1\services\UserService
     */
    protected function getService()
    {
        if ($this->_service === null) {

            $this->_service = new \frontend\modules\v1\services\UserService();
        }

        
        return $this->_service;
    }

}