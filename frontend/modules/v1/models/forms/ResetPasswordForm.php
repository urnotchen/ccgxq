<?php

namespace frontend\modules\v1\models\forms;

use common\components\ValidateErrorCode;
use frontend\modules\v1\models\User;


class ResetPasswordForm extends \yii\base\Model
{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;

    public $email, $code, $password;
    private $_user;

    public function rules()
    {
        return [
            [['email', 'code', 'password'], 'required'],
            [['email', 'code', 'password'], 'string', 'max' => 255],

            ['email', 'validateEmail'],
        ];
    }

    public function validateEmail($attr, $params)
    {
//        if ($this->hasErrors()){
//            return false;
//        }

        $user = User::findOne(['email' => $this->email]);

        if (empty($user)) {
            throw new \yii\web\HttpException(
                400, '邮箱未注册',
                ValidateErrorCode::EMAIL_NOT_REGISTERED
            );

        }

        $this->_user = $user;
    }

    /**
     * @param $rawParams
     * @param bool $runValidation
     * @return User
     * @throws \yii\web\HttpException
     */
    public function prepare($rawParams, $runValidation = true)
    {
        $this->load( $rawParams , '');

        if ($runValidation){
            $this->validate();
        }

        # 验证修改的密码与原密码是否相同
        # todo 将修改密码与重置密码的验证合并
        if($this->_user->validatePassword($this->password)){
            throw new \yii\web\HttpException(
                400, 'password is not change',
                \common\components\ResponseCode::USER_PASSWORD_NOT_CHANGE
            );
        }

        return $this->_user;
    }

}
