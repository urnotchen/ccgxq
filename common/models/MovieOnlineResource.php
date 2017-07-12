<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_online_resource".
 *
 * @property integer $id
 * @property string $movie_id
 * @property string $definition
 * @property string $created_at
 * @property string $updated_at
 */
class MovieOnlineResource extends \yii\db\ActiveRecord
{

    use \common\traits\EnumTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    const DEFINITION_OTHER = 1, DEFINITION_720P = 2,DEFINITION_1080P = 3,DEFINITION_BLURAY = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_online_resource';
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
            [['movie_id', 'definition'], 'required'],
            [['movie_id', 'definition', 'created_at', 'updated_at'], 'integer'],
            [['movie_id','definition'],'unique','targetAttribute' => ['movie_id', 'definition']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => '电影',
            'definition' => '清晰度',
            'created_at' => '加入时间',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getEnumData(){

        return [
            'definition' => [
                self::DEFINITION_720P => '720P',
                self::DEFINITION_1080P => '1080P',
                self::DEFINITION_BLURAY => '蓝光',
                self::DEFINITION_OTHER => '其他'
            ]
        ];
    }
    public function getMovie(){

        return $this->hasOne(Movie::className(),['id' => 'movie_id']);
    }
}
