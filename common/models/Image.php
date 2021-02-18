<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "film_pic".
 *
 * @property string $id
 * @property string $movie_id
 * @property string $filmmaker_id
 * @property string $user_id
 * @property string $pic_id
 * @property string $path
 * @property string $douban_url
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_pic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','type','source'], 'integer'],
            [['item_id','item_id', 'pic_id', 'path', 'url'], 'string', 'max' => 255],
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
            'filmmaker_id' => 'Filmmaker ID',
            'user_id' => 'User ID',
            'pic_id' => 'Pic ID',
            'path' => 'Path',
            'douban_url' => 'Douban Url',
        ];
    }
}
