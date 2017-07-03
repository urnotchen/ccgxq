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

    public $email, $password, $device, $name, $type,$registrationID;

    private $_user;

    public function rules()
    {
        return [
//            [['email', 'password', 'device','registrationID', 'name'], 'spe_required'],
//            [['email', 'password', 'device','registrationID', 'name'], 'required'],
//            [['email', 'password','registrationID'], 'string'],

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
            throw new \yii\web\HttpException(
                401,
                '邮箱未注册',
                \common\components\ValidateErrorCode::EMAIL_NOT_REGISTERED
            );
        }
        $this->_user = $user;
    }

    public function validatePassword($attr, $params)
    {
        if ($this->hasErrors()){
            return false;
        }

        if (! $this->_user->validatePassword($this->password)) {
            throw new \yii\web\HttpException(
                401,
                '用户密码不匹配',
                \common\components\ValidateErrorCode::PASSWORD_NOT_MATCH
            );
//            $this->addError($attr, ValidateErrorCode::PASSWORD_NOT_MATCH);
//            return false;
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
