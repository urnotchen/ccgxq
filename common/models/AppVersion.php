<?php

namespace common\models;


/**
 * This is the model class for table "app_version".
 *
 * @property integer $id
 * @property string $version
 * @property integer $is_imp
 * @property string $title
 * @property string $content
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class AppVersion extends \yii\db\ActiveRecord
{
    use \common\traits\EnumTrait;
    use \common\traits\FindOrExceptionTrait;

    const VERSION_IS_NEWEST = 0, VERSION_NOT_IMPORTANT = 1, VERSION_IS_IMPORTANT = 2;
    const OS_IOS = 1, OS_ANDROID = 2;

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'blameable' => \yii\behaviors\BlameableBehavior::className()
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_v';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version', 'is_imp'], 'required'],
            [['is_imp'], 'integer'],
            [['version', 'title', 'content'], 'string', 'max' => 255],
            [['version'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version' => '版本号',
            'is_important' => '是否强制更新',
            'title' => '标题',
            'content' => '通知',
            'created_at' => 'Created At',
        ];
    }
    
    public static function getEnumData()
    {
        return [
            'is_imp' => [
                self::VERSION_NOT_IMPORTANT => '建议更新',
                self::VERSION_IS_IMPORTANT  => '强制更新',
            ],
            'os' => [
                self::OS_IOS => 'IOS',
                self::OS_ANDROID => '安卓'
            ]
        ];
    }
}
