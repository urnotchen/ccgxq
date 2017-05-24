<?php

namespace frontend\modules\v1\models\forms;

use frontend\modules\v1\models\AppVersion;

class AppVersionForm extends \yii\base\Model
{
    use \common\traits\ModelPrepareTrait;

    public $version, $os;

    public function rules()
    {
        return [
            [['version', 'os'], 'required'],
            ['version', 'string'],
            ['os', 'in', 'range' => array_keys(AppVersion::enum('os'))]
        ];
    }
}
