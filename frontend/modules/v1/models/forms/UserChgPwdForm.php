<?php

namespace frontend\modules\v1\models\forms;

use common\components\ResponseCode;
use common\components\ValidateErrorCode;

class UserChgPwdForm extends \yii\base\Model
{

    use \common\traits\ModelPrepareTrait;
    use \frontend\modules\v1\traits\UserModelTrait;

    public $token, $password;

    public function rules()
    {
        return [
//            [['token', 'password'], 'required'],
            ['token', 'string'],
            ['password', 'string', 'min' => 6, 'max' => 64],
            ['token', 'validateToken'],
        ];
    }

    public function validateToken($attr, $params)
    {
        if ($this->hasErrors()) {

            return false;
        }

        $error = \Yii::$app->passwordTokenCache->validateToken($this->getUser(), $this->$attr);
        if ($error) {

//            $this->addError($attr, $error);
//            return false;
            throw new \yii\web\HttpException(
                401, 'token 已过期',
               ValidateErrorCode::TOKEN_EXPIRED
            );
        }

        # 验证修改的密码与原密码是否相同
        # todo 将修改密码与重置密码的验证合并
        if($this->getUser()->validatePassword($this->password)){
            throw new \yii\web\HttpException(
                401, 'password is not change',
                \common\components\ResponseCode::USER_PASSWORD_NOT_CHANGE
            );
        }

        \Yii::$app->passwordTokenCache->delToken($this->getUser());
    }

}

