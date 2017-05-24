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

                return $titleList?$titleList[0]:'';
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
            'producer_country' => function($model){
                return $model->producer_country?explode('/',trim($model->producer_country)):[];
            },
            'score',
            'release_date',
            'release_year' => function($model){
                return (int)$model->release_year;
            },
            'play_video_num' => function($model){
                $onlineResource =  MovieIndex::isOnlineResource($model->id)?1:0 ;
                $websiteResource = FilmVideoConn::getResourceNum($model->id);
                return $onlineResource + $websiteResource;
            },

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
            'filmmaker' => function($model){
                return  $model->filmmaker;
            },
            'synopsis',
            'websiteResource',
        ];
    }
    public function getWebsiteResource(){
        return $this->hasMany(FilmVideoConn::className(),['movie_id' => 'id']);
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

    public function getFilmmaker(){
        return $this->hasMany(FilmmakerRoleConn::className(),['movie_id' => 'id']);
    }

    public function getSynopsis(){
        return $this->hasMany(FilmSynopsis::className(),['movie_id' => 'id']);
    }

}

?>