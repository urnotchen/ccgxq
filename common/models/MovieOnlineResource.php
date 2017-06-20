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
            'movie_id' => 'Movie ID',
            'definition' => 'Definition',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
