<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/18
 * Time: 16:50
 */

namespace frontend\modules\v1\controllers;

use frontend\components\rest\Controller;
use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\FilmRecommendUser;
use frontend\modules\v1\models\forms\MovieDetailsForm;
use frontend\modules\v1\models\forms\MovieZhanListForm;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\services\MovieListService;

use frontend\modules\v1\services\ZhanService;
use yii\data\ActiveDataProvider;

class ZhanController extends Controller{

    protected $_service;

    public function behaviors()
{
    $inherit = parent::behaviors();

    $inherit['authenticator']['only'] = [
        'recommend','pass'
    ];
    $inherit['authenticator']['authMethods'] = [
        \frontend\modules\v1\components\AccessTokenAuth::className(),
    ];



    return $inherit;
}

    public function verbs()
    {
        return [
            'recommend'    => ['get'],
            'pass'    => ['post'],

        ];
    }

    /*
     * 电影斩列表(不需要timeline,不需要参数)
     * */
    public function actionRecommend()
    {

        $rawParams = \Yii::$app->getRequest()->get();

        $movieNum = 20;

        $userId= \Yii::$app->getUser()->id;

        //不是第一次,就找有无未推荐完的电影(官方20部剩余的或是扩展推荐剩余的,choice的为default)
        //如果有剩余,就推荐剩余的
        //没有剩余,推荐扩展的
        //如果扩展的都推荐完了,形成环路,没有可推荐的了,就在官方推荐里再找20部推荐,循环
        //是否推荐过电影斩

        //todo 把缓存加上


        //是否是第一次进入电影斩(判断type有无official)
        if (FilmRecommendUser::yetRecommend($userId)) {

            //不是第一次,就找有无未推荐完的电影(官方20部剩余的或是扩展推荐剩余的,choice的为default)
            $waitSeeMovies = $this->service->getWaitSeeRecommendMovies($userId,$movieNum);

            //如果待看的电影有20部,直接返回待看的电影列表
            if(count($waitSeeMovies) == $movieNum){
                $movieIds = $this->service->arFieldId($waitSeeMovies,'id');
                $this->service->addLastRecommendCache($userId,$movieIds);
                return $waitSeeMovies;
            }

            //获取已评分电影的扩展
            $scoredExpandMovies = $this->service->getScoredExpandMovies($userId,$waitSeeMovies,$movieNum - count($waitSeeMovies));
//return count($scoredExpandMovies);
            //如果待看的电影和评分扩展的电影加一起有20部,返回待看和评分扩展的电影列表
            if(count($scoredExpandMovies) + count($waitSeeMovies) == $movieNum){
                $this->service->addRecommendRecordByAr(array_merge($waitSeeMovies,$scoredExpandMovies),$userId,FilmRecommendUser::TYPE_USER);

                return array_merge($waitSeeMovies,$scoredExpandMovies);
            }

            //获取想看的电影的扩展
            $likedExpandMovies = $this->service->getLikeExpandMovies($userId,array_merge($waitSeeMovies,$scoredExpandMovies),$movieNum - count($waitSeeMovies) - count($scoredExpandMovies));

            //如果待看的电影,评分扩展的电影,想看扩展的电影加一起有20部,返回待看,评分扩展的电影列表
            if(count($scoredExpandMovies) + count($waitSeeMovies) + count($likedExpandMovies) == $movieNum){
                $this->service->addRecommendRecordByAr(array_merge($waitSeeMovies,$scoredExpandMovies,$likedExpandMovies),$userId,FilmRecommendUser::TYPE_USER);
                return array_merge($waitSeeMovies,$scoredExpandMovies,$likedExpandMovies);
            }
            //如果以上的电影列表凑不到20部,就再生成一次官方推荐给用户
            return $this->service->generateOfficialZhan($userId);

//            return $this->service->userRecommend($rawParams);
        } else {
            //第一次进入,没被推荐过 推荐官方的,生成20部
            //也有可能是一直在过 没有合适的 也要重新推荐20部
            //电影斩官方推荐不缓存,因为要随机
            return $this->service->generateOfficialZhan($userId);
//            $query = Movie::getMovieListByProperty(FilmProperty::PROPERTY_RECOMMEND_OFFICIAL, $userId);
//            $queryClone = clone $query;
//            FilmRecommendUser::addToRecommendRecord($queryClone->select('movie.id')->column(), $userId, FilmRecommendUser::TYPE_OFFICIAL);
//            return $query->all();
        }
    }


    public function actionPass(){

        $rawParams = \Yii::$app->getRequest()->post();

        $form = new MovieDetailsForm();
        $movie = $form->prepare($rawParams);
        return FilmRecommendUser::moviePass(\Yii::$app->getUser()->id,$movie->id);

    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new ZhanService();
        }

        return $this->_service;
    }


}