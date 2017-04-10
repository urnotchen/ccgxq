<?php

namespace frontend\modules\v1\models;

class Movie extends \frontend\models\Movie
{
    public function fields()
    {
        return [
            'name_cn',
            'name_en',
            'poster',
            'director',
            'actor',
            'grade_db',
            'show_time'
        ];
    }

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