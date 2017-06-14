<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/19
 * Time: 18:44
 */
namespace frontend\modules\v1\services;
use frontend\modules\v1\helpers\QueryHelper;
use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\forms\MovieListTimeline;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\models\forms\SearchTimeline;
use frontend\modules\v1\models\FilmRecommendUser;
use frontend\modules\v1\models\FilmRecommend;
use yii\db\Query;

class MovieListService extends  \common\services\MovieListService{

    /*
     * 电影列表
     * */
    public function movieList($rawParams)
    {
        $max = isset($rawParams['max'])?$rawParams['max']:0;
        $since = isset($rawParams['since'])?$rawParams['since']:0;
        $count = isset($rawParams['count'])?$rawParams['count']:0;
        $type = $rawParams['type'];
        $user_id = $this->getUser()->id;

        $cache = \Yii::$app->cache;

        if ($cache->get("movie_list_{$type}_{$max}_{$since}_{$count}")) {
            return $cache->get("movie_list_{$type}_{$max}_{$since}_{$count}");
        } else {
            $query = Movie::getMovieListByProperty($type,$user_id);
            $res = MovieListTimeline::timeline($rawParams,QueryHelper::executeMultiTimelineQuery($query));
            $cache->set("movie_list_{$type}_{$max}_{$since}_{$count}", $res, 60 * 60);

            return $res;
        }
    }




    /*
     * 电影斩用户个人推荐
     * */
//    public function userRecommend($rawParams){
//
//        $query = Movie::userRecommendQuery();
//
//        return MovieListTimeline::timeline($rawParams,QueryHelper::executeMultiTimelineQuery($query));
//
//    }

    /*
     * 用户个人电影数据列表
     * */
    public function userChoiceList($rawParams,$user_id){

        $query = Movie::userChoiceListQuery($rawParams['type'],$user_id);

        return MovieListTimeline::timeline($rawParams,QueryHelper::executeMultiTimelineQuery($query));


    }

    /*
     * 用户个人电影数据列表筛选
     * */
    public function userStarSawList($rawParams,$user_id){


        $query = Movie::userStarSawListQuery($user_id,$rawParams['star']);
        return MovieListTimeline::timeline($rawParams,QueryHelper::executeMultiTimelineQuery($query));

    }

    public function keyword($rawParams){

//        return Movie::getSearchNum($rawParams['keyword']);
        return [['num' => Movie::getSearchNum($rawParams['keyword'])],SearchTimeline::timeline($rawParams, [
            'title','alias','actor','director','screen_writer'
        ])];

    }




}