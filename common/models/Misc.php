<?php

namespace common\models;

/**
 * Class Misc
 * @package common\models
 *
 * @property integer $id
 * @property string $policy
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */

class Misc extends \yii\db\ActiveRecord
{
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    public static function tableName()
    {
        return 'misc';
    }

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'blameable' => \yii\behaviors\BlameableBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            ['policy', 'string'],
            ['policy', 'required']
        ];
    }
}

?>