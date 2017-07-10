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

    const NAME_USER_AGREEMENT = 'user_agreement' , NAME_QINIU_INFO = 'qiniu_info';

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
            [['policy','name','explain','explain'], 'string'],
            [['policy','name'], 'required']
        ];
    }

    public static function getQiniuInfo(){

        $res = self::findOne(['name' => self::NAME_QINIU_INFO]);

        if($res){
            return $res->policy;
        }
        return null;
    }

    public static function getPolicyInfo(){

        return self::findOne(['name' => self::NAME_USER_AGREEMENT]);
    }
}

?>