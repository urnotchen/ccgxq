<?php

namespace common\models;


class MovieResource extends \yii\db\ActiveRecord
{
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    public static function tableName()
    {
        return 'movie_resource';
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
            ['movie_id', 'integer'],
            ['movie_id', 'exist', 'targetClass' => Movie::className(), 'targetAttribute' => 'id'],
            [['bilibili', 'vqq', 'iqiyi', 'youku', 'souhu', 'acfun'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => 'MOVIE ID',
            'bilibili' => '哔哩哔哩',
            'vqq' => '腾讯视频',
            'iqiyi' => '爱奇艺',
            'youku' => '优酷',
            'souhu' => '搜狐',
            'acfun' => 'AcFun',
            'created_at' => 'CREATED AT',
            'created_by' => 'CREATED BY',
            'updated_at' => 'UPDATED AT',
            'updated_by' => 'UPDATED BY'
        ];
    }

}