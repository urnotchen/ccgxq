<?php

namespace frontend\modules\v1\models\forms;


class UserPasswordForm extends \yii\base\Model
{

    use \common\traits\ModelPrepareTrait;
    use \frontend\modules\v1\traits\UserModelTrait;

    public $password;

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'max' => '64'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attr, $params)
    {
        if ($this->hasErrors()) {

            return false;
        }

        if (! $this->getUser()->validatePassword($this->password)) {

            $this->addError($attr, \common\components\ValidateErrorCode::PASSWORD_NOT_MATCH);
        }
    }

}
