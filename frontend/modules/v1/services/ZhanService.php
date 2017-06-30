<?php

namespace frontend\modules\v1\services;

use backend\modules\movie\models\FilmProperty;
use frontend\modules\v1\models\FilmRecommend;
use Yii;
use frontend\modules\v1\models\Zhan;
use frontend\modules\v1\models\FilmRecommendUser;
use frontend\modules\v1\models\Movie;


class ZhanService extends \common\services\BizService
{

    /*
     * 电影斩生成官方推荐
     * */
    public function generateOfficialZhan($userId){
        $query = Zhan::getMovieListByProperty(FilmProperty::PROPERTY_RECOMMEND_OFFICIAL, $userId);
        $query->limit(20);
        $queryClone = clone $query;
        FilmRecommendUser::addToRecommendRecord($queryClone->select('movie.id')->column(), $userId, FilmRecommendUser::TYPE_OFFICIAL);
        return $query->all();
    }

    /*
     * 获取以前未推荐完的电影(已经生成了电影,但用户还没看)
     * 缓存里的也算(上次推荐的)
     * */
    public function getWaitSeeRecommendMovies($userId,$movieNum){

        //获取用户待看的电影推荐
        //判断用户上次推荐的缓存 不要重复(因为客户端在第17,8张左右的时候就会请求新的电影斩,后面的2,3张就是待看的,排除这几张)
        $cache = \Yii::$app->cache;

        return Zhan::find()->joinWith('filmRecommendUser')
            ->where([FilmRecommendUser::tableName().'.user_id' => $userId,FilmRecommendUser::tableName().'.choice' => [FilmRecommendUser::CHOICE_DEFAULT]])
            ->andWhere(['not',['movie_id' => $cache->get('lastRecommend_'.$userId)]])
            ->limit($movieNum)->all();

    }

    /*
     * 获取已经评分了的电影的扩展电影
     * @param $alreadyMovieIds 已经准备好了的电影id(待推荐)
     * */
    public static function getScoredExpandMovies($userId,$alreadyMovies,$movieNum){
        ///判断待看的电影数量是否满足要显示的电影数量
//        if($movieNum == count($waitSeeMovies)){
        //数量已经够了,直接返回
//            return $waitSeeMovies;
//        }else{
        //数量不够,要用扩展电影来补
//        }}

        $alreadyMovieIds = FilmRecommendUser::getUserAllMovieIds($userId);

        foreach($alreadyMovies as $eachMovie){
            array_push($alreadyMovieIds,$eachMovie->id);
        }
        $userMovieIds = FilmRecommendUser::find()->select('movie_id')

//            ->where(['user_id' => $userId, 'choice' => [FilmRecommendUser::CHOICE_SAW],'status' => FilmRecommendUser::STATUS_WAIT_RECOMMEND])
            //不管是不是在电影斩里面评分的 都推荐关联的
            ->where(['user_id' => $userId,'status' => FilmRecommendUser::STATUS_WAIT_RECOMMEND])
            ->andWhere(['>=','star',3])
            ->column();
//        $movieIds = FilmRecommend::find()->select('recommend_movie_id')
//            ->join('join','film_recommend_user',FilmRecommend::tableName().'.movie_id='. FilmRecommendUser::tableName().'.movie_id')
//            ->where(['user_id' => $userId, 'choice' => [FilmRecommendUser::CHOICE_SAW]])
//            ->andWhere(['>=','star',3])
//            ->andWhere(['not',[FilmRecommend::tableName().'.recommend_movie_id' => $alreadyMovieIds]])
//            ->groupBy(FilmRecommend::tableName().'.recommend_movie_id')
//            ->column();
        $num = $movieNum;
        $expandMovies = [];

        foreach($userMovieIds as $eachMovieId){
            $recommendMovieIds = FilmRecommend::find()->select('recommend_movie_id')
                ->where(['movie_id' => $eachMovieId])
                ->andWhere(['not',['recommend_movie_id' => $alreadyMovieIds]])
                ->groupBy('recommend_movie_id')
                ->limit($num)->column();
            $alreadyMovieIds = array_merge($alreadyMovieIds,$recommendMovieIds);
            if(count($recommendMovieIds) < $num){
                //更改这条推荐的状态,未推荐变成已推荐
                FilmRecommendUser::toRecommended($userId,$eachMovieId);
            }
            $eachMovieExpandMovies = Zhan::find()
                ->where(['id' => $recommendMovieIds])
                ->limit($num)->all();
            $expandMovies = array_merge($expandMovies,$eachMovieExpandMovies);
            $num = $num - count($recommendMovieIds);
            if($num == 0 ) break;
        }

        return $expandMovies;
    }

    /*
     * 获取收藏电影的扩展电影
     * @param $alreadyMovieIds 已经准备好了的电影id(待推荐)
     * */
    public static function getLikeExpandMovies($userId,$alreadyMovies,$movieNum){

        $alreadyMovieIds = FilmRecommendUser::getUserAllMovieIds($userId);

        foreach($alreadyMovies as $eachMovie){
            array_push($alreadyMovieIds,$eachMovie->id);
        }

        $expandMovies = Zhan::find()->joinWith('filmRecommend')->joinWith('filmRecommendUser')
            ->select(FilmRecommendUser::tableName().'.movie_id')
            ->where(['user_id' => $userId, 'choice' => [FilmRecommendUser::CHOICE_COLLECT]])
            ->andWhere(['not',[FilmRecommend::tableName().'.recommend_movie_id' => $alreadyMovieIds]])
            ->limit($movieNum)->all();

        return $expandMovies;
    }

    /*
     * 获取进几个月内的几部新片
     * */
    public function getNewestMovies($userId,$alreadyMovies,$monthNum,$movieNum){

        $alreadyMovieIds = FilmRecommendUser::getUserAllMovieIds($userId);

        foreach($alreadyMovies as $eachMovie){
            array_push($alreadyMovieIds,$eachMovie->id);
        }

        return Zhan::getNewestMovies($alreadyMovieIds,$monthNum,$movieNum);

    }

    /*
     * 把筛选后后续的推荐添加到推荐表中
     * 主要的工作是把ar中的id提取出来
     * */

    public function addRecommendRecordByAr($arList,$userId,$type){

        $movieIds = $this->arFieldId($arList,'id');

        //添加到缓存
        $this->addLastRecommendCache($userId,$movieIds);
        //添加到数据库推荐列表
        FilmRecommendUser::addToRecommendRecord($movieIds,$userId,$type);
    }

    /*
     * 提取ar活动记录中的某列
     * */
    public function arFieldId($arList,$field){

        $movieIds = [];
        foreach($arList as $ar){
            array_push($movieIds,$ar->{$field});
        }
        return $movieIds;

    }




    /*
     * 把上一次的推荐电影列表加入到缓存中
     * */
    public function addLastRecommendCache($userId,$movieIds){

        $cache = \Yii::$app->cache;

        $cache->set('lastRecommend_'.$userId,$movieIds);

    }


}
