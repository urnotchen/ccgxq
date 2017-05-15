<?php

namespace frontend\modules\v1\models;

class Movie extends \frontend\models\Movie
{
//    public function fields()
//    {
//        return [
//            'id',
//            'name_cn',
//            'name_en',
//            'poster',
//            'director' => function(self $model) {
//                return \yii\helpers\Json::decode($model->director);
//            },
//            'actor' => function(self $model) {
//                return \yii\helpers\Json::decode($model->actor);
//            },
//            'grade_db',
//            'show_time',
//            'imdb',
//            'douban'
//        ];
//    }

    public function extraFields()
    {
        return [
            'movieResource',
            'onlineResource'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieResource()
    {
        return $this->hasOne(MovieResource::className(), ['movie_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineResource()
    {
        return $this->hasOne(OnlineResource::className(), ['movie_id' => 'id']);
    }
}

?>