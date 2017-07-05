<?php

namespace backend\controllers;

use backend\helper\BasicHelper;
use backend\helper\MovieHelper;
use backend\models\FilmChoiceUser;
use backend\models\FrontUser;
use backend\models\Movie;
use backend\models\MovieOnlineResource;
use backend\models\UserToken;
use backend\modules\movie\services\MovieListService;
use common\helpers\DateHelper;
use common\services\StatisticsService;

use common\models\StatDaily;
use common\models\StatWeekly;
use common\models\StatMonthly;

use backend\models\User;
use Yii;

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

        $inherit['access'] = ['class' => \yii\filters\AccessControl::className(),
            'rules' => [
                [
                    'actions' => [
                        'update-zhan','movie-resource','push','report','stat-user'
                    ],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

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

        $today = Yii::$app->dateFormat->getTodayTimestamp();
        $count = Yii::$app->redis->bitcount(StatDaily::buildDailyStatKey());

        $statDaily = StatDaily::getInstance(['day' => $today]);
        $statDaily->day = $today;
        $statDaily->count = $count;
        $statDaily->daily = Yii::$app->redis->get(StatDaily::buildDailyStatKey());
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

    public function statComment(){


    }

    /*
     * 测试 这个字符串是push()返回的msg_id
     * */
    public function actionReport(){

        return Yii::$app->JPush->report('2011677591');

    }


}
