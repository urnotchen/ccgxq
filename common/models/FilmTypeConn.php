<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "film_type_conn".
 *
 * @property string $id
 * @property string $movie_id
 * @property string $type_id
 */
class FilmTypeConn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_type_conn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'type_id'], 'integer'],
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
            'type_id' => 'Type ID',
        ];
    }

}
