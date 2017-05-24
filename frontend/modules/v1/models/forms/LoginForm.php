<?php

namespace frontend\modules\v1\models\forms;

use common\components\ValidateErrorCode;

use frontend\modules\v1\models\User;
use frontend\modules\v1\models\UserToken;

class LoginForm extends \yii\base\Model
{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;

    public $email, $password, $device, $name, $type;

    private $_user;

    public function rules()
    {
        return [
            [['email', 'password', 'device', 'name'], 'required'],
            [['email', 'password', 'device', 'name'], 'string'],
            ['type', 'integer'],
            ['type', 'default', 'value' => UserToken::TYPE_PHONE],

            ['email', 'validateEmail'],
            ['password', 'validatePassword']
        ];
    }

    public function validateEmail($attr, $params)
    {
        if ($this->hasErrors()){
            return false;
        }

        $user = User::findOne(['email' => $this->email]);

        if (empty($user)) {
            $this->addError($attr, ValidateErrorCode::EMAIL_NOT_REGISTERED);
            return false;
        }

        $this->_user = $user;
    }

    public function validatePassword($attr, $params)
    {
        if ($this->hasErrors()){
            return false;
        }

        if (! $this->_user->validatePassword($this->password)) {
            $this->addError($attr, ValidateErrorCode::PASSWORD_NOT_MATCH);
            return false;
        }
    }

    /**
     * @param bool $runValidation
     * @return User
     */
    public function save($runValidation = true)
    {
        if ($runValidation){

            $this->validate();
        }

        return $this->_user;
    }

}
