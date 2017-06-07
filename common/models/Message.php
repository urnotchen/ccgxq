<?php

namespace common\models;

use common\traits\FindOrExceptionTrait;
use common\traits\SaveExceptionTrait;
use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $movie_id
 * @property string $user_id
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Message extends \yii\db\ActiveRecord
{

    use FindOrExceptionTrait;
    use SaveExceptionTrait;


    const STATUS_NOT_READ = 1,STATUS_YET_READ = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'user_id'], 'required'],
            [['movie_id', 'user_id', 'status','created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['status'],'default','value' => self::STATUS_NOT_READ],
            [['content'],'string','max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => 'Movie ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
