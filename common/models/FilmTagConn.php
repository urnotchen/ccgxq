<?php

namespace common\models;

use backend\modules\movie\models\FilmTag;
use Yii;

/**
 * This is the model class for table "film_tag_conn".
 *
 * @property string $id
 * @property string $movie_id
 * @property string $tag_id
 */
class FilmTagConn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_tag_conn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'tag_id'], 'integer'],
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
            'tag_id' => 'Tag ID',
        ];
    }

    public static function getMovieTag($movieId){
        $res = self::find()->where(['movie_id' => $movieId])->all();
        $arr = [];
        foreach($res as $tagConn){
//            var_dump($arr);
            $arr = array_merge($arr,[$tagConn->tags->name]);
        }
//        var_dump($arr);
        return $arr;
    }

    public function getTags(){
        return $this->hasOne(FilmTag::className(),['id' => 'tag_id']);
    }
}
