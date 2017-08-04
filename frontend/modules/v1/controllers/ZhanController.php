<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/18
 * Time: 16:50
 */

namespace frontend\modules\v1\controllers;

use frontend\components\rest\Controller;
use frontend\modules\v1\models\FilmChoiceUser;
use frontend\modules\v1\models\FilmComment;
use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\FilmRecommendUser;
use frontend\modules\v1\models\FilmTypeConn;
use frontend\modules\v1\models\forms\MovieDetailsForm;
use frontend\modules\v1\models\forms\MovieZhanListForm;
use frontend\modules\v1\models\forms\ZhanRevocationForm;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\services\MovieListService;

use frontend\modules\v1\services\StatisticsService;
use frontend\modules\v1\services\ZhanService;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class ZhanController extends Controller{

    protected $_service;
    protected $_statisticsService;

    public function behaviors()
{
    $inherit = parent::behaviors();

    $inherit['authenticator']['only'] = [
        'recommend','pass','recommend-test','revocation'
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
        $newNum = 2;
        $highNum = 5;
        $likeNum = 13;
        $userId= $this->getUser()->id;
        //不是第一次,就找有无未推荐完的电影(官方20部剩余的或是扩展推荐剩余的,choice的为default)
        //如果有剩余,就推荐剩余的
        //没有剩余,推荐扩展的
        //如果扩展的都推荐完了,形成环路,没有可推荐的了,就在官方推荐里再找20部推荐,循环
        //是否推荐过电影斩

        //todo 把缓存加上


        //是否是第一次进入电影斩(判断type有无official)
        if (FilmRecommendUser::yetRecommend($userId)) {

            //不是第一次,就找有无未推荐完的电影(官方20部剩余的或是扩展推荐剩余的,choice的为default)

            //判断用户看过的电影超没超过100部,超过则需要推荐1部已看过的电影
            $sawMovies = [];
            if(FilmRecommendUser::needSawRecommend($userId)){
                $sawMovies = $this->service->getSawMovie($userId,1);
            }
            $waitSeeMovies = $this->service->getWaitSeeRecommendMovies($userId,$movieNum);

            //如果待看的电影有20部,直接返回待看的电影列表
            if(count($waitSeeMovies) == $movieNum){
//                $movieIds = $this->service->arFieldId($waitSeeMovies,'id');
//                $this->service->addLastRecommendCache($userId,$movieIds);
                $this->service->addRecommendRecordByAr(array_merge($waitSeeMovies),$userId,FilmRecommendUser::TYPE_USER);
                return array_merge($waitSeeMovies,$sawMovies);
            }else{
                $waitSeeMovies = $this->service->getWaitSeeRecommendMovies($userId,$likeNum);
            }


            $arr = $waitSeeMovies;

            if(count($arr) < $likeNum) {
                //获取已评分电影的扩展
                $scoredExpandMovies = $this->service->getScoredExpandMovies($userId, $waitSeeMovies, $likeNum - count($waitSeeMovies));

                //如果待看的电影和评分扩展的电影加一起有20部,返回待看和评分扩展的电影列表
                if (count($scoredExpandMovies) + count($waitSeeMovies) < $likeNum) {
//                $this->service->addRecommendRecordByAr(array_merge($waitSeeMovies,$scoredExpandMovies),$userId,FilmRecommendUser::TYPE_USER);

                    $arr = array_merge($arr, $scoredExpandMovies);
                }
                if(count($arr) < 13) {
                    //获取想看的电影的扩展
                    $likedExpandMovies = $this->service->getLikeExpandMovies($userId, array_merge($waitSeeMovies, $scoredExpandMovies), $movieNum - count($waitSeeMovies) - count($scoredExpandMovies));

                    //如果待看的电影,评分扩展的电影,想看扩展的电影加一起有20部,返回待看,评分扩展的电影列表
                    $arr = array_merge($arr, $likedExpandMovies);

                }
            }
            if (count($arr) < $likeNum) {
                //推荐电影不足再生成一次电影斩
//                $zhanOfficial = $this->service->generateOfficialZhan($userId);
//                if($zhanOfficial){
//                    return $zhanOfficial;
//                }else{
//
//                    $arrNew = $this->service->getNewestMovies($userId,array_merge($arr),12,$movieNum - count($arr));
//
//                    if (count($arr) + count($arrNew) == $movieNum) {
//                        $this->service->addRecommendRecordByAr(array_merge($arr,$arrNew), $userId, FilmRecommendUser::TYPE_USER);
//                        return array_merge($arr,$arrNew);
//                    }
//                }
                //推荐电影不足 改为推荐7分以上的电影 按照评价人数从多到少排序推荐
                $commonMovies = $this->service->getCommonMovies($userId,$movieNum);
                $this->service->addRecommendRecordByAr($commonMovies,$userId,FilmRecommendUser::TYPE_COMMON);
                return array_merge($commonMovies,$sawMovies);
            }
//            if($movieNum - count($scoredExpandMovies) - count($waitSeeMovies) - count($likedExpandMovies) <= 2) {

            //5部高分片
            $types = [];
            foreach($arr as $each){
                $types = array_merge(FilmTypeConn::getType($each->id));
            }
            $types = array_unique($types);

            $arrHigh = $this->service->getHighMovies($userId,$arr,$types,$highNum);
            //不是第一次,就先找3个月内的2部新片
            $arrNew = $this->service->getNewestMovies($userId,array_merge($arr,$arrHigh),3,2);
//            $this->service->addRecommendRecordByAr(array_merge($arr,$arrHigh, $newestMovies), $userId, FilmRecommendUser::TYPE_USER);
//            $arrNew =  array_merge($arr,$arrHigh, $newestMovies);

            if(count($arr) + count($arrHigh) + count($arrNew) == 20){
                $this->service->addRecommendRecordByAr(array_merge($arr,$arrHigh,$arrNew),$userId,FilmRecommendUser::TYPE_USER);
                return array_merge($arr,$arrHigh,$arrNew,$sawMovies);
            }
            //如果以上的电影列表凑不到20部,就再生成一次官方推荐给用户
//            if(count($this->service->generateOfficialZhan($userId)) == 20){
//                return $this->service->generateOfficialZhan($userId);
//            }else{

            //推荐电影不足 改为推荐7分以上的电影 按照评价人数从多到少排序推荐
            $commonMovies = $this->service->getCommonMovies($userId,$movieNum);
            $this->service->addRecommendRecordByAr($commonMovies,$userId,FilmRecommendUser::TYPE_COMMON);
            return array_merge($commonMovies,$sawMovies);
//            }

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
        return FilmRecommendUser::moviePass($this->getUser()->id,$movie->id);

    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new ZhanService();
        }

        return $this->_service;
    }
    protected function getStatisticsService()
    {
        if ($this->_service === null) {
            $this->_statisticsService = new StatisticsService();
        }

        return $this->_statisticsService;
    }


    /*
    * 电影斩列表(不需要timeline,不需要参数)
    * */
    public function actionRecommendTest()
    {

        $rawParams = \Yii::$app->getRequest()->get();

        $movieNum = 20;

        $userId= $this->getUser()->id;

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
//            return 2;
            //如果待看的电影有20部,直接返回待看的电影列表
            if(count($waitSeeMovies) == $movieNum){
//                $movieIds = $this->service->arFieldId($waitSeeMovies,'id');
//                $this->service->addLastRecommendCache($userId,$movieIds);
                $this->service->addRecommendRecordByAr(array_merge($waitSeeMovies),$userId,FilmRecommendUser::TYPE_USER);
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

            //不是第一次,就先找3个月内的2部新片
            if($movieNum - count($scoredExpandMovies) - count($waitSeeMovies) - count($likedExpandMovies) <= 2) {
                $newestMovies = $this->service->getNewestMovies($userId,array_merge($waitSeeMovies,$scoredExpandMovies,$likedExpandMovies),6,$movieNum - count($scoredExpandMovies) - count($waitSeeMovies) - count($likedExpandMovies));
                if (count($scoredExpandMovies) + count($waitSeeMovies) + count($likedExpandMovies) == $movieNum) {
                    $this->service->addRecommendRecordByAr(array_merge($waitSeeMovies, $scoredExpandMovies, $likedExpandMovies, $newestMovies), $userId, FilmRecommendUser::TYPE_USER);
                    return array_merge($waitSeeMovies, $scoredExpandMovies, $likedExpandMovies, $newestMovies);
                }
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

    /*
     * 电影斩撤销操作
     * */
    public function actionRevocation(){

        $rawParams = \Yii::$app->getRequest()->post();

        $form = new ZhanRevocationForm();

        $form->prepare($rawParams);

        $userId = $this->getUser()->id;
        try {
            //如果是看过操作 删除评论
            if($form->type == FilmChoiceUser::TYPE_SAW) {
                FilmComment::delComment($form->movie_id, $userId);
                $this->statisticsService->setCommentCount(time(),$userId,0);
            }
            // 删除看过
            FilmChoiceUser::userAction($userId,$form->movie_id,$form->type,FilmChoiceUser::ACTION_DELETE,FilmChoiceUser::SOURCE_ZHAN);

            $this->statisticsService->zhanUserChoiceCount(time(),$form->type,$userId,0);
        }catch(Exception $e){
            throw new \yii\web\HttpException(
                403, '撤销失败',
                \common\components\ResponseCode::REVOCATION_FAILED
            );
        }
        return true;
    }

}