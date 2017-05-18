<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_index".
 *
 * @property integer $id
 * @property string $imdb
 * @property integer $douban
 * @property integer $create_at
 * @property integer $update_at
 */
class MovieIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_index';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['douban', 'create_at', 'update_at'], 'integer'],
            [['create_at', 'update_at'], 'required'],
            [['imdb'], 'string', 'max' => 20],
            [['imdb'], 'unique'],
            [['douban'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imdb' => 'Imdb',
            'douban' => 'Douban',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    public function getMovieDisk(){
        return $this->hasMany(MovieDisk::className(),['movie_id' => 'id']);
    }

    public function getMovieLink(){
        return $this->hasMany(MovieLink::className(),['movie_id' => 'id']);
    }


    public static function isOnlineResource($movie_id){
        return self::findOne(['douban' => $movie_id])?True:False;

    }
}
