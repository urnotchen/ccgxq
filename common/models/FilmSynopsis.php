<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "film_synopsis".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property string $text
 * @property integer $source
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class FilmSynopsis extends \yii\db\ActiveRecord
{
    const SOURCE_DOUBAN = 1 ,SOURCE_MTIME = 2 , SOURCE_USER = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_synopsis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'source', 'created_at', 'created_by', 'updated_at', 'updated_by','user_id'], 'integer'],
            [['content'], 'string'],
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
            'content' => 'Content',
            'source' => 'Source',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
