<?php

namespace frontend\modules\v1\models\forms;

use frontend\modules\v1\models\User;

class ValidateCaptchaForm extends \yii\base\Model
{
    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;

    public $email, $captcha;
    private $_user;

    public function rules()
    {
        return [
            [['email', 'captcha'], 'required'],
            ['email', 'email'],
            ['captcha', 'string'],

            ['email', 'validateEmail'],
        ];
    }

    public function validateEmail($attr, $params)
    {
        if ($this->hasErrors()){
            return false;
        }

        $user = User::findOne(['email' => $this->email]);

        if (empty($user)) {
            $this->addError($attr, \common\components\ValidateErrorCode::EMAIL_NOT_REGISTERED);
            return false;
        }

        $this->_user = $user;
    }

    public function prepare($rawParams, $runValidation = true)
    {
        $this->load( $rawParams , '');

        if ($runValidation){

            $this->validate();
        }

        \Yii::$app->captchaCache->checkChance($this->_user, $this->captcha);

        return true;
    }
}
