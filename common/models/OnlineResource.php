<?php

namespace common\models;


class OnlineResource extends \yii\db\ActiveRecord
{
    use \common\traits\EnumTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    const DEFINITION_BLURAY = 1, DEFINITION_HIGH = 2;

    public static function tableName()
    {
        return 'online_resource';
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
            ['movie_id', 'required'],
            [['movie_id', 'definition'], 'integer'],
            ['movie_id', 'exist', 'targetClass' => Movie::className(), 'targetAttribute' => 'id'],
            ['url', 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => 'MOVIE ID',
            'url' => '链接',
            'definition' => '清晰度',
            'created_at' => 'CREATED AT',
            'created_by' => 'CREATED BY',
            'updated_at' => 'UPDATED AT',
            'updated_by' => 'UPDATED BY'
        ];
    }

    public static function getEnumData()
    {
        return [
            'definition' => [
                self::DEFINITION_BLURAY => '蓝光',
                self::DEFINITION_HIGH => '高清'
            ]
        ];
    }
}