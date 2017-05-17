<?php

namespace frontend\modules\v1\models;

class Movie extends \frontend\models\Movie
{
    public function fields()
    {
        return [
            'id' => function($model){
                return (int)$model->id;
            },
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
            'score'=>function($model){
                return $model->score?$model->score:'';
            },
            'release_date',
        ];
    }

    public function extraFields()
    {
        return [
            'onlineResource' => function($model){
                if($model->onlineResource){
                    return $model->onlineResource;
                }
                if($model->onlineResource2){
                    return $model->onlineResource2;
                }
                return '';
            },
            'image',
        ];
    }

    public function getOnlineResource(){
        return $this->hasOne(MovieIndex::className(),['douban' => 'id']);
    }

    public function getOnlineResource2(){
        return $this->hasOne(MovieIndex::className(),['imdb' => 'imdb_title']);
    }

    public function getImage(){
        return $this->hasOne(Image::className(),['id' => 'pic_id']);
    }

}

?>