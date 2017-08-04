<?php

namespace backend\controllers;

use backend\helper\BasicHelper;
use backend\helper\MovieHelper;
use backend\models\FilmChoiceUser;
use backend\models\FilmProperty;
use backend\models\FilmRecommend;
use backend\models\FrontUser;
use backend\models\Movie;
use backend\models\MovieOnlineResource;
use backend\models\ScrapyUpdateProcess;
use backend\models\StatMovie;
use backend\models\StatUserAction;
use backend\models\UserToken;
use backend\modules\movie\services\MovieListService;
use common\helpers\Curl;
use common\helpers\DateHelper;
use common\services\StatisticsService;

use common\models\StatDaily;
use common\models\StatWeekly;
use common\models\StatMonthly;

use backend\models\User;
use Yii;
use yii\db\Exception;
use yii\helpers\BaseJson;

/*}}}*/


class ApiController extends \yii\rest\Controller
{

    protected $_service;
    protected $_statisticsService;

    public function behaviors()
    {/*{{{*/
        $inherit = parent::behaviors();

        $inherit['contentNegotiator']['formats']['application/xml'] = \yii\web\Response::FORMAT_JSON;
        $inherit['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;
//
//        $inherit['access'] = ['class' => \yii\filters\AccessControl::className(),
//            'rules' => [
//                [
//                    'actions' => [
//                        'update-zhan','movie-resource','push','report','stat-user','scrapy-update','stat-comment','stat-choice-zhan','stat-subscribe-movies','stat-want-movies',
//                    ],
//                    'allow' => true,
//                    'roles' => ['?'],
//                ],
//            ],
//        ];


        return $inherit;
    }/*}}}*/

    public function actionUpdateZhan(){

        $this->service->updateZhan();
    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new MovieListService();
        }

        return $this->_service;
    }

    public function getStatisticsService(){

        if ($this->_statisticsService === null) {
            $this->_statisticsService = new StatisticsService();
        }

        return $this->_statisticsService;
    }
    /*
     * 网络资源写入接口
     * */
    public function actionMovieResource(){

        $params = \Yii::$app->getRequest()->post();
        foreach($params as $eachArray) {
            MovieOnlineResource::record($eachArray);
        }

        return true;
    }

    /*
     * 推送
     * */
    public function actionPush(){

        //根据用户查找用户订阅的电影
        //循环推送
        $userIds = FrontUser::getUserIds();

        $pushIds = [];

        foreach($userIds as $userId => $registrationId){

            $nameList = Movie::getWaitPushMovieNameList($userId);

            if(!$nameList){
                continue;
            }else{
                $pushIds[] = $userId;
            }
            $content = '';

            foreach($nameList as $eachName){

                $content .= MovieHelper::getChineseName($eachName).'、';
            }

            $content .= '网上可以看了';

            $userRegistrationIds = UserToken::getRegistrationIds($userId);

            foreach($userRegistrationIds as $eachUserRegistrationId){

                Yii::$app->JPush->send($registrationId,$content);

            }

            FilmChoiceUser::pushed($userId);
        }
        return $pushIds;
    }

    //暂时不用 用分镜的统计
    /*public function actionStatDaily(){

        //判断今天是1号?统计上个月的月活(落地) 今天是周一?统计上周周活(落地)

        //添加进日活表
        $dailyStr = BasicHelper::strToBinStr($this->statisticsService->getDailyCount());
        $count = $this->statisticsService->getDailyCount();

        $dayBeginAt = strtotime(date("Y-m-d"));

        StatDaily::dailyRecord($count,$dailyStr,$dayBeginAt,$dayBeginAt + 86400);
        //判断是不是周一
//        if(date("N") == 1){
            //先找上周七天的缓存数据
        $this->statWeekly();
            //如果这一天的缓存数据没有 就去数据库里找

            //数据库里要是也没有 就不管了
//        }
        //判断是不是1号
    }*/
/*
    public function statWeekly(){

        $size = FrontUser::find()->max('id');
        $thisWeek = DateHelper::getWeekMonday(time());
        $weekDay = date('N');
        $weekCount = 0;

        for ($i=1; $i<=$size; ++$i) {
            $count = 0;

            for ($j=0; $j<$weekDay; ++$j) {
                $key = $this->statisticsService->buildDailyStatKey($thisWeek + 86400 * $j);
                $count += Yii::$app->redis->getbit($key, $i);

                //每周登录两天为周活
                if ($count >= StatDaily::WEEK_ACTIVE_DAY) {
                    $weekCount += 1;

                    //本用户统计完成退出循环
                    break;
                }
            }
        }

        $statWeekly = StatDaily::getInstance(['week' => $thisWeek,'type' => StatDaily::TYPE_WEEK]);
        $statWeekly->type = StatDaily::TYPE_WEEK;
        $statWeekly->month = date("m",$thisWeek);
        $statWeekly->year = date("Y",$thisWeek);
        $statWeekly->week = $thisWeek;
        $statWeekly->count = $weekCount;
        $statWeekly->begin_at = $thisWeek;
        $statWeekly->end_at = $thisWeek + 7 * 86400;

        return $statWeekly->save();

    }*/

    /**
     * 每日统计
     *
     * @return bool
     */
    public function actionStatUser()
    {
//        Header::validateStat();

        $yesterday = DateHelper::getYesterdayTimestamp(time());

        $count = Yii::$app->redis->bitcount(StatDaily::buildDailyStatKey($yesterday));
        $statDaily = StatDaily::getInstance(['day' => $yesterday]);
        $statDaily->day = $yesterday;
        $statDaily->count = $count;
        $statDaily->daily = Yii::$app->redis->get(StatDaily::buildDailyStatKey($yesterday));
        $statDaily->save();

        $this->statWeekly();
        $this->statMonthly();

        return true;
    }

    /**
     * @return bool
     */
    protected function statWeekly()
    {
        $size = User::find()->max('id');
        $thisWeek = Yii::$app->dateFormat->getThisWeekTimestamp();
        $weekDay = date('N');
        $weekCount = 0;

        for ($i=1; $i<=$size; ++$i) {
            $count = 0;

            for ($j=0; $j<$weekDay; ++$j) {
                $key = StatDaily::buildDailyStatKey($thisWeek + StatDaily::DAY*$j);
                $count += Yii::$app->redis->getbit($key, $i);

                //每周登录两天为周活
                if ($count >= 2) {
                    $weekCount += 1;

                    //本用户统计完成退出循环
                    break;
                }
            }
        }

        $statWeekly = StatWeekly::getInstance(['week' => $thisWeek]);
        $statWeekly->week = $thisWeek;
        $statWeekly->count = $weekCount;

        return $statWeekly->save();
    }

    /**
     * @return bool
     */
    protected function statMonthly()
    {
        $monthDay = date('j');
        //当前月活统计方式每月前10天不会产生月活用户
        if ($monthDay < 10) {

            return true;
        }

        $size = User::find()->max('id');
        $thisMonth = Yii::$app->dateFormat->getThisMonthTimestamp();

        $monthCount = 0;

        for ($i=1; $i<=$size; ++$i) {
            $count = 0;
            $interval = 0;
            $rest = 0;

            for ($j=0; $j<$monthDay; ++$j) {
                $key = StatDaily::buildDailyStatKey($thisMonth + StatDaily::DAY*$j);
                $dayStatus = Yii::$app->redis->getbit($key, $i);

                if ($dayStatus) {
                    $count += $dayStatus;

                    if ($interval >= 7) {
                        //剩余登陆日累加
                        if ($count >= 2) {

                            $rest += 1;
                        }

                        //剩余登陆日大于等于2 总登陆日大于等于4则为月活用户
                        if ($rest>=2 && $count>=4) {
                            $monthCount += 1;

                            break;
                        }
                    }

                    //从第一个登陆日开始累加间隔直到间隔为7
                    $interval =+ 1;
                } else {
                    //从第一个登陆日开始累加间隔直到间隔为7
                    if ($count >= 1) {

                        $interval += 1;
                    }
                }
            }
        }

        $statMonthly = StatMonthly::getInstance(['month' => $thisMonth]);
        $statMonthly->month = $thisMonth;
        $statMonthly->count = $monthCount;

        return $statMonthly->save();
    }


    /*
     * 短评统计,每日有多少人评论了电影
     * */
    public function actionStatComment(){

        $dayTimestamp = DateHelper::getYesterdayTimestamp(time());

        $count = Yii::$app->redis->bitcount($this->statisticsService->buildDailyCommentKey($dayTimestamp));
        $daily = Yii::$app->redis->get($this->statisticsService->buildDailyCommentKey($dayTimestamp));

        StatUserAction::addRecord($dayTimestamp,$count,$daily,StatUserAction::TYPE_COMMENT);

    }

    /*
     * 标记电影统计 每日有多少人用电影斩标记了电影  想看 看过(评星) 订阅
     * */
    public function actionStatChoiceZhan(){

        $dayTimestamp = DateHelper::getYesterdayTimestamp(time());
        foreach(StatUserAction::ZHAN_TYPE_LIST as $eachType => $filmChoiceUserType) {
            $count = Yii::$app->redis->bitcount($this->statisticsService->buildDailyStatChoiceZhan($dayTimestamp,$filmChoiceUserType));
            $daily = Yii::$app->redis->get($this->statisticsService->buildDailyStatChoiceZhan($dayTimestamp,$filmChoiceUserType));
            StatUserAction::addRecord($dayTimestamp, $count, $daily, StatUserAction::TYPE_CHOICE_BY_ZHAN,$eachType);
        }
    }

    /*
     * 统计 想看 数量最多的前30部电影
     * */
    public function actionStatWantMovies(){

        $dayTimestampRange = DateHelper::getYesterdayTimestamp(time());

        $movieList = FilmChoiceUser::getMaxMovieIds(FilmChoiceUser::TYPE_WANT);

        foreach($movieList as $eachMovieId => $num){
            StatMovie::addRecord($dayTimestampRange,StatMovie::TYPE_WANT,$eachMovieId,$num);
        }
    }

    /*
     * 统计 订阅 数量最多的前30部电影
     * */
    public function actionStatSubscribeMovies(){

        $dayTimestampRange = DateHelper::getYesterdayTimestamp(time());

        $movieList = FilmChoiceUser::getMaxMovieIds(FilmChoiceUser::TYPE_SUBSCRIBE);

        foreach($movieList as $eachMovieId => $num){
            StatMovie::addRecord($dayTimestampRange,StatMovie::TYPE_SUBSCRIBE,$eachMovieId,$num);
        }

    }

    /*
     * 测试 这个字符串是push()返回的msg_id
     * */
    public function actionReport(){

        return Yii::$app->JPush->report('2011677591');

    }

    /*
     * 更新豆瓣采集列表
     * 每天1点运行一次
     * */
    public function actionScrapyUpdate(){

        $today = strtotime(date("Y-m-d"));
        $yesterday = $today - 86400;

        //3个月内上映的片子 一周更新一次
         $weekUpdMovieIds = Movie::getMoiveIdsBy3Months($today);

        //如果有人订阅了该电影 且没有资源的 一周采一次
        //这个暂时不做了 因为是以网上资源为主的

        //movie_online_resource表中有资源但是电影表里没有的电影 添加到列表
        $noMovieIds = MovieOnlineResource::getNoMovieIds($yesterday,$today);
        //如果有前一天没采集或者采集失败的 加入列表 失败次数大于3 不采了
        $errorScrapyAr = ScrapyUpdateProcess::getReScrapeId($yesterday);

        //把没有关联电影没有采到的加入到采集,限制500部
        $recommendIds = FilmRecommend::getNoRecommendIds();

        //将这些添加到待采集数据库中
        try {
            foreach (array_merge($weekUpdMovieIds, $noMovieIds,$recommendIds) as $movieId) {
                ScrapyUpdateProcess::addRecord($today, $movieId);
            }
            foreach ($errorScrapyAr as $eachAr) {
                ScrapyUpdateProcess::addRecord($today, $eachAr->movie_id, $eachAr->error_times + 1, $eachAr->referer, $eachAr->movie_url);
            }
        }catch(Exception $e){
            //有错误也要继续运行

        }
    }

    /*
     * 自动添加最新,最热的属性
     * 每天16点运行一次
     * */
    public function actionAutoFilmProperty(){

        //热门列表转换成最新列表,


        $newestApi = 'https://api.douban.com/v2/movie/in_theaters?count=40&city=yes';
        $hotApi = 'https://movie.douban.com/j/search_subjects?type=movie&tag=%E7%83%AD%E9%97%A8&page_limit=40&page_start=0';

        $newestArr = BaseJson::decode(Curl::httpGet($newestApi, $https = true));
        $hotJson = BaseJson::decode(Curl::httpGet($hotApi, $https = true));

        //热门电影 => 最新列表
        foreach($hotJson['subjects'] as $eachMovie){
            preg_match('/subject\/(\d+)/',$eachMovie['url'],$movieId);
            $movieId = (isset($movieId[1])?$movieId[1]:'');
            if($movieId) {
                FilmProperty::autoAddFilmProperty($movieId, FilmProperty::PROPERTY_NEWEST);
            }
        }
        //清空热门列表的顺序
        $movieHotList = FilmProperty::getList(FilmProperty::PROPERTY_HOT);
        foreach($movieHotList as $eachMovie) {
            $eachMovie->sequence = null;
            $eachMovie->save();
        }
        //接口 正在热映 => 热门列表
        $i = count($newestArr['subjects']);
        foreach($newestArr['subjects'] as $eachMovie){
            preg_match('/subject\/(\d+)/',$eachMovie['alt'],$movieId);
            $movieId = (isset($movieId[1])?$movieId[1]:'');
            if($movieId) {
                $record = FilmProperty::autoAddFilmProperty($movieId, FilmProperty::PROPERTY_HOT);
                if($record){
                    $record->sequence = $i;
                    $record->save();
                    $i--;
                }
            }
        }

        $movieHotList = FilmProperty::getList(FilmProperty::PROPERTY_HOT);
        foreach($movieHotList as $eachMovie) {
            $resource = MovieOnlineResource::findOne(['movie_id' => $eachMovie->movie_id]);
            if ($resource) {
                if ($eachMovie->sequence != 0) {
                    $frontRows = FilmProperty::find()->where(['>', 'sequence', $eachMovie->sequence])->andWhere(['property' => $eachMovie->property])->all();

                    foreach ($frontRows ? $frontRows : [] as $eachRow) {
                        $eachRow->sequence -= 1;
                        $eachRow->save();
                    }
                }
                $eachMovie->delete();
                FilmProperty::autoAddFilmProperty($eachMovie->movie_id, FilmProperty::PROPERTY_NEWEST);
            }
        }
    }


}
