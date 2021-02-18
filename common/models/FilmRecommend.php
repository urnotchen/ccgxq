<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "film_recommend".
 *
 * @property string $id
 * @property string $movie_id
 * @property string $recommend_movie_id
 */
class FilmRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_recommend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'recommend_movie_id'], 'integer'],
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
            'recommend_movie_id' => 'Recommend Movie ID',
        ];
    }

    public static function getRecommend($movieId){
        $arr = [];
        $res = self::find()->where(['movie_id' => $movieId])->all();
        foreach($res as $recommend){
            if($recommend->movie) {
                $arr = array_merge($arr, [explode(' ', $recommend->movie->title)[0]]);
            }
        }
        return $arr;
    }

    public function getMovie(){
        return $this->hasOne(Movie::className(),['id' => 'recommend_movie_id']);
    }
}
