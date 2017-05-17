<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_link".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property string $name
 * @property string $url
 * @property integer $definition
 * @property integer $size
 * @property integer $create_at
 * @property integer $update_at
 */
class MovieLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'name', 'url', 'create_at', 'update_at'], 'required'],
            [['movie_id', 'definition', 'size', 'create_at', 'update_at'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
            [['url'], 'unique'],
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
            'name' => 'Name',
            'url' => 'Url',
            'definition' => 'Definition',
            'size' => 'Size',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
