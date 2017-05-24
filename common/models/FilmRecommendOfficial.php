<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "film_recommend_official".
 *
 * @property integer $id
 * @property string $movie_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $sequence
 */
class FilmRecommendOfficial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_recommend_official';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'sequence'], 'integer'],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'sequence' => 'Sequence',
        ];
    }
}
