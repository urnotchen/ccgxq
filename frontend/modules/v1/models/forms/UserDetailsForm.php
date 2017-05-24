<?php

namespace frontend\modules\v1\models\forms;


class UserDetailsForm extends \yii\base\Model
{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;
    use \common\traits\FilterableArrayTrait;

    public $nickname, $avatar, $gender, $address, $career, $birth;

    public function rules()
    {
        return [
            [['nickname'], 'required'],

            [['avatar', 'nickname', 'address'], 'string', 'max' => 255],
            [['gender', 'career', 'birth'], 'integer'],
        ];
    }

    public function prepare($rawParams, $runValidation = true)
    {
        $this->load($rawParams, '');

        if ($runValidation){

            $this->validate();
        }

        return true;
    }

    public function getAttributesForAr()
    {
        return $this->toFilterArray([
            'nickname',
            'avatar',
            'gender',
            'career',
            'address',
            'birth'
        ]);
    }

}
