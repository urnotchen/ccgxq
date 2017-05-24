<?php

namespace frontend\modules\v1\models\forms;


class ForceLogoutForm extends \yii\base\Model
{
    use \common\traits\ModelPrepareTrait;

    public $device;

    public function rules()
    {
        return [
            ['device', 'required'],
            ['device', 'string'],
        ];
    }

}