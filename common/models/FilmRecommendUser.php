<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "film_recommend_user".
 *
 * @property integer $id
 * @property string $movie_id
 * @property integer $type
 * @property integer $star
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class FilmRecommendUser extends \yii\db\ActiveRecord
{
    const TYPE_OFFICIAL = 1,TYPE_USER = 2;

    const STATUS_WAIT_RECOMMEND = 1 , STATUS_YET_RECOMMEND = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_recommend_user';
    }
    public function behaviors()
    {/*{{{*/
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::classname(),
        ];
    }/*}}}*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'user_id','type', 'star','status', 'created_at', 'updated_at'], 'integer'],
            [['movie_id'],'unique'],
            [['status'],'default','value' => self::STATUS_WAIT_RECOMMEND]
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
            'type' => 'Type',
            'star' => 'Star',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
