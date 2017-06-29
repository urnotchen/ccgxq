<?php

namespace frontend\modules\v1\models;

use frontend\modules\v1\helpers\QueryHelper;
use yii\db\Expression;
use yii\db\Query;

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
            'type'=> function($model){
                return $model->type?explode('/',trim($model->type)):[];
            },
            'local_name'=> function($model){
                $titleList = explode(' ',$model->title,2);
                $alias = count($titleList) == 2 ? $titleList[1] : null;

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
                return $model->release_year?(int)$model->release_year:null;
            },
            'play_video_num' => function($model){
                $onlineResource =  MovieOnlineResource::isOnlineResource($model->id)?1:0 ;
                $websiteResource = FilmVideoConn::getResourceNum($model->id);
                return $onlineResource + $websiteResource;
            },
            'subscribe_num' => function($model){
                return (int)FilmChoiceUser::getUserChoiceNum($model->id,FilmChoiceUser::TYPE_SUBSCRIBE);
            },
            'wantSee' => function($model){
                return FilmChoiceUser::existAction($model->id,FilmChoiceUser::TYPE_WANT);
            },
            'subscribe' => function($model){
                return FilmChoiceUser::existAction($model->id,FilmChoiceUser::TYPE_SUBSCRIBE);
            }


        ];
    }

    public function extraFields()
    {
        return [
            'onlineResource' => function($model){
                return $model->movieOnlineResource?$model->movieOnlineResource:null;
            },
            'image',
            'filmmaker' => function($model){
                return  $model->filmmaker;
            },

            'websiteResource',
            'comment' => function($model){
                return FilmComment::getUserComment(\Yii::$app->getUser()->id,$model->id);
            },
            'synopsis',
        ];
    }
    public function getWebsiteResource(){
        return $this->hasMany(FilmVideoConn::className(),['movie_id' => 'id']);
    }


    public function getMovieOnlineResource(){
        return $this->hasMany(MovieOnlineResource::className(),['movie_id' => 'id'])->max('definition');
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

    public static function getMovieListByProperty($property,$user_id = null ){

        switch ($property) {
            case FilmProperty::PROPERTY_NEWEST:
                $query = self::find()->select('movie.*,(select @rownum:=0)')->join('join', MovieOnlineResource::tableName(), Movie::tableName() . '.id=' . MovieOnlineResource::tableName() . '.movie_id')
                    ->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->propertyNewestSequence();
                break;
            case FilmProperty::PROPERTY_SELECTED:
                $query = self::find()->select('movie.*,(select @rownum:=0)')->join('join', MovieOnlineResource::tableName(), Movie::tableName() . '.id=' . MovieOnlineResource::tableName() . '.movie_id')
                    ->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->releaseTimestampSequence();
                break;
            case FilmProperty::PROPERTY_HOT:
                $query = self::find()->select('movie.*,(select @rownum:=0)')->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            case FilmProperty::PROPERTY_RECOMMEND_OFFICIAL:
                $query = self::find()->select('movie.*,(select @rownum:=0)')->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->andWhere(['not',[Movie::tableName().'.id' => FilmRecommendUser::getUserAllMovieIds($user_id)]])
                    ->limit(20)
                    ->orderBy('rand()');
//                    ->propertyHotSequence();
                break;
            default :
                throw new \yii\web\HttpException(
                    400, "movie list doesn't have this property",
                    \common\components\ResponseCode::INVALID_MOVIE_LIST_PROPERTY
                );
        }
        return $query;
    }

    /*
    * 用户个人电影数据列表
    * */
    public static function userChoiceListQuery($type,$user_id){

        $query = self::find()->select('movie.*,(select @rownum:=0)')
            ->join('join',FilmChoiceUser::tableName(),FilmChoiceUser::tableName().'.movie_id='.Movie::tableName().'.id')
            ->where([FilmChoiceUser::tableName().'.type' => $type,FilmChoiceUser::tableName().'.user_id' => $user_id])
            ->andWhere([FilmChoiceUser::tableName().'.status' => FilmChoiceUser::STATUS_NORMAL])
            ->orderBy([FilmChoiceUser::tableName().'.updated_at' => SORT_DESC]);

       return $query;
    }

    public static function userStarSawListQuery($user_id,$star)
    {

        $query = self::find()->select('movie.*,(select @rownum:=0)')
            ->join('join', FilmChoiceUser::tableName(), FilmChoiceUser::tableName() . '.movie_id=' . Movie::tableName() . '.id')
            ->join('join', FilmComment::tableName(), FilmComment::tableName() . '.user_id=' . FilmChoiceUser::tableName() . '.user_id'.' and '.FilmComment::tableName().'.movie_id='.FilmChoiceUser::tableName().'.movie_id')
            ->where([FilmChoiceUser::tableName() . '.type' => FilmChoiceUser::TYPE_SAW, FilmChoiceUser::tableName() . '.user_id' => $user_id])
            ->andWhere(['not', [FilmChoiceUser::tableName() . '.status' => FilmChoiceUser::STATUS_TRASH]])
            ->andWhere([FilmComment::tableName() . '.star' => $star, FilmComment::tableName() . '.type' => FilmComment::TYPE_USER])
            ->andWhere([FilmComment::tableName() . '.user_id' => $user_id])
            ->orderBy([FilmChoiceUser::tableName() . '.updated_at' => SORT_DESC]);

        return $query;
    }

    /*
     * 用户个人推荐列表
     *
     * */
//    public static function userRecommendQuery(){
//
//        $user_id = \Yii::$app->getUser()->id;
//        $subQuery = (new Query())->select('recommend_movie_id,(select @rownum:=0)')->from(FilmRecommendUser::tableName())
//            ->join('join',FilmRecommend::tableName(),FilmRecommend::tableName().'.movie_id='.FilmRecommendUser::tableName().'.movie_id')
//            ->where([FilmRecommendUser::tableName().'.user_id' => $user_id])
//            ->where(['>=',FilmRecommendUser::tableName().'.star' ,3])
//            ->andWhere([FilmRecommendUser::tableName().'.status' => FilmRecommendUser::STATUS_WAIT_RECOMMEND])
//            ->andWhere(['not',[FilmRecommend::tableName().'.recommend_movie_id' => FilmRecommendUser::getRecommendedMovieIds($user_id)]])
//            ->createCommand()->getRawSql();
//
//        $query = Movie::find()->join('join',"({$subQuery}) as k",'movie.id = '.'k.recommend_movie_id')->limit(13);
//
//        return $query;
//    }


    public static function getSearchNum($keyword){

        $fields = ['title','alias','actor','director','screen_writer'];
        $query = self::find();
        foreach($fields as $eachField){
            $query->orFilterWhere(['like',$eachField,$keyword]);
        }
        return $query->count();
    }


}

?>