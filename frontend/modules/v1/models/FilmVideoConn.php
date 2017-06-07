<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/4/26
 * Time: 15:14
 */
namespace frontend\modules\v1\models;

class FilmVideoConn extends \frontend\models\FilmVideoConn{

    public function fields()
    {
        return [
            'id',
            'website' => function($model){
                return $model->website->id;
            },
            'url',
        ];
    }

    public function extraFields()
    {
        return [
            'onlineResource' => function($model) {
                if ($model->onlineResource) {
                    return $model->onlineResource;
                }
                if ($model->onlineResource2) {
                    return $model->onlineResource2;
                }
                return '';
            },
        ];

    }

    public function getOnlineResource(){
        return $this->hasOne(MovieIndex::className(),['douban' => 'id']);
    }
    public function getOnlineResource2(){
        return $this->hasOne(MovieIndex::className(),['imdb' => 'imdb_title']);
    }

}