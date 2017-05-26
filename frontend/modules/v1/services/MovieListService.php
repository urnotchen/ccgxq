<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/19
 * Time: 18:44
 */
namespace frontend\modules\v1\services;
use frontend\modules\v1\helpers\QueryHelper;
use frontend\modules\v1\models\FilmChoiceUser;
use frontend\modules\v1\models\FilmComment;
use frontend\modules\v1\models\forms\MovieListTimeline;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\MovieIndex;
use frontend\modules\v1\models\forms\SearchTimeline;
use yii\data\ActiveDataProvider;
use frontend\modules\v1\models\FilmRecommendUser;
use frontend\modules\v1\models\FilmRecommend;
use yii\db\Query;

class MovieListService extends  \common\services\MovieListService{

    public function movieList($rawParams)
    {
        $max = isset($rawParams['max'])?$rawParams['max']:0;
        $since = isset($rawParams['since'])?$rawParams['since']:0;
        $count = isset($rawParams['count'])?$rawParams['count']:0;
        $type = $rawParams['type'];


        $cache = \Yii::$app->cache;

        if ($cache->get("movie_list_{$type}_{$max}_{$since}_{$count}")) {
            return $cache->get("movie_list_{$type}_{$max}_{$since}_{$count}");
        } else {
            $query = Movie::getMovieListByProperty($type);
            $res = MovieListTimeline::timeline($rawParams,QueryHelper::executeMultiTimelineQuery($query));
            $cache->set("movie_list_{$type}_{$max}_{$since}_{$count}", $res, 60 * 60);

            return $res;
        }
    }

    /*
     * 电影斩用户个人推荐
     * */
    public function userRecommend($user_id){

        $query = Movie::find();
        $subQuery = (new Query())->select('recommend_movie_id')->from(FilmRecommendUser::tableName())
            ->join('join',FilmRecommend::tableName(),FilmRecommend::tableName().'.movie_id='.FilmRecommendUser::tableName().'.movie_id')
            ->where([FilmRecommendUser::tableName().'.user_id' => $user_id])
            ->andWhere([FilmRecommendUser::tableName().'.status' => FilmRecommendUser::STATUS_WAIT_RECOMMEND])
            ->createCommand()->getRawSql();

        $query->join('join',"({$subQuery}) as k",'movie.id = '.'k.recommend_movie_id')->limit(13);
//        return $query->createCommand()->getRawSql();
//        $query = 'select movie.* from film_recommend_user join film_recommend on film_recommend_user.movie_id = film_recommend.movie_id join movie on movie.id=film_recommend.recommend_movie_id where user_id = 2 and status = 1;';
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20,
            ]
        ]);
    }

    /*
     * 用户个人电影数据列表
     * */
    public function userChoiceList($user_id,$type){

        $query = Movie::find()
            ->join('join',FilmChoiceUser::tableName(),FilmChoiceUser::tableName().'.movie_id='.Movie::tableName().'.id')
            ->where([FilmChoiceUser::tableName().'.type' => $type,FilmChoiceUser::tableName().'.user_id' => $user_id])
            ->andWhere(['not',[FilmChoiceUser::tableName().'.status' => FilmChoiceUser::STATUS_TRASH]])
            ->orderBy([FilmChoiceUser::tableName().'.updated_at' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ],
        ]);
    }

    /*
     * 用户个人电影数据列表筛选
     * */
    public function userStarSawList($user_id,$star){

        $query = Movie::find()
            ->join('join',FilmChoiceUser::tableName(),FilmChoiceUser::tableName().'.movie_id='.Movie::tableName().'.id')
            ->join('join',FilmComment::tableName(),FilmComment::tableName().'.user_id='.FilmChoiceUser::tableName().'.user_id')
            ->where([FilmChoiceUser::tableName().'.type' => FilmChoiceUser::TYPE_SAW,FilmChoiceUser::tableName().'.user_id' => $user_id])
            ->andWhere(['not',[FilmChoiceUser::tableName().'.status' => FilmChoiceUser::STATUS_TRASH]])
            ->andWhere([FilmComment::tableName().'.star' => $star,FilmComment::tableName().'.type' => FilmComment::TYPE_USER])
            ->orderBy([FilmChoiceUser::tableName().'.updated_at' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ],
        ]);
    }

    public function keyword($rawParams){

        return SearchTimeline::timeline($rawParams, [
            'title','alias','actor','director','screen_writer'
        ]);

    }




}