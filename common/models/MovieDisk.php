<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_disk".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property string $name
 * @property string $url
 * @property string $passwd
 * @property integer $definition
 * @property integer $create_at
 * @property integer $update_at
 */
class MovieDisk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_disk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'name', 'url', 'definition', 'create_at', 'update_at'], 'required'],
            [['movie_id', 'definition', 'create_at', 'update_at'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
            [['passwd'], 'string', 'max' => 10],
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
            'passwd' => 'Passwd',
            'definition' => 'Definition',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
