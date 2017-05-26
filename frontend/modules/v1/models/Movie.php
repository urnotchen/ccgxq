<?php

namespace frontend\modules\v1\models;

use frontend\modules\v1\helpers\QueryHelper;
use yii\db\Expression;

class Movie extends \frontend\models\Movie
{

    public $idTemp;
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

            'websiteResource',
            'comment' => function($model){
                return FilmComment::getUserComment(\Yii::$app->getUser()->id,$model->id);
            },
            'synopsis'
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
        return $this->hasOne(FilmSynopsis::className(),['movie_id' => 'id']);
    }

    public static function getMovieListByProperty($property){

        switch ($property) {
            case FilmProperty::PROPERTY_NEWEST:
                $query = Movie::find()->select('movie.*,(select @rownum:=0)')->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                    ->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->propertyNewestSequence();
                break;
            case FilmProperty::PROPERTY_SELECTED:
                $query = Movie::find()->select('movie.*,(select @rownum:=0)')->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                    ->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->releaseTimestampSequence();
                break;
            case FilmProperty::PROPERTY_HOT:
                $query = Movie::find()->select('movie.*,(select @rownum:=0)')->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            case FilmProperty::PROPERTY_RECOMMEND_OFFICIAL:
                $query = Movie::find()->select('movie.*,(select @rownum:=0)')->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            default :
                throw new \yii\web\HttpException(
                    400, "movie list doesn't have this property",
                    \common\components\ResponseCode::INVALID_MOVIE_LIST_PROPERTY
                );
        }

        //获取电影列表的query
//        $query =  $query->createCommand()->getRawSql();
//        $query2 = new \common\models\queries\Query(Movie::className());
//        //生成列idTemp
//        $query2->select(new Expression("@rownum := @rownum +1 as idTemp,t.*"))->from(new Expression("({$query} )as t"));
//        $query2 = $query2->createCommand()->getRawSql();
//
        return $query;



    }

}

?>