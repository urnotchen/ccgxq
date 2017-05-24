<?php

namespace frontend\modules\v1\models\forms;

use frontend\modules\v1\models\User;

class SendRePwdCaptForm extends \yii\base\Model
{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;

    public $email;
    private $_user;

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],

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

        if ($runValidation) {

            $this->validate();
        }

        return $this->_user;
    }

}
