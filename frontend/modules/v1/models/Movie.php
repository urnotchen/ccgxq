<?php

namespace frontend\modules\v1\models;

class Movie extends \frontend\models\Movie
{
    public function fields()
    {
        return [
            'id',
            'name' => function($model){
                $titleList = explode(' ',$model->title,2);

                return $titleList[0];
            },
            'local_name'=> function($model){
                $titleList = explode(' ',$model->title,2);
                $alias = count($titleList) == 2 ? $titleList[1] : '';

                return $alias;
            },
            'director'=> function($model){
                return $model->director?explode('/',$model->director):[];
            },
            'actor'=> function($model){
                return $model->actor?explode('/',$model->actor):[];
            },
        ];
    }

    public function extraFields()
    {
        return [
            'movieResource',
            'onlineResource',
            'image',
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'pic_id']);
    }
}

?>