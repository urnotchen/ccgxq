<?php

namespace frontend\modules\v1\models\forms;

use frontend\modules\v1\models\UserToken;

class RegisterForm extends \yii\base\Model
{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;
    use \common\traits\FilterableArrayTrait;

    public $email;
    public $password;
    public $nickname;
    public $device;
    public $name;
    public $type;
    public $registrationID;

    public function rules()
    {
        return [
            [['email', 'password', 'device','registrationID', 'name'], 'required'],
            [['device', 'name', 'nickname','registrationID'], 'string'],
            ['type', 'integer'],
            ['type', 'default', 'value' => UserToken::TYPE_PHONE],
            ['email', 'email'],

            # length
            ['password', 'string', 'max' => 255],
        ];
    }

    public function prepare($rawParams, $runValidation = true)
    {
        $this->load( $rawParams , '');

        if ($runValidation) {

            $this->validate();
        }

        //邮箱前缀作为用户名
        $this->setAttributes(['nickname' => substr($this->email, 0, strpos($this->email, "@"))]);

        return [
            $this->getAttrsForUser(),
            $this->getAttrsForUserDetail(),
        ];
    }

    protected function getAttrsForUser()
    {
        return $this->toFilterArray([
            'email',
            'password',
        ]);
    }

    protected function getAttrsForUserDetail()
    {
        return $this->toFilterArray([
            'nickname',
        ]);
    }

}
