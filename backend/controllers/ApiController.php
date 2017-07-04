<?php

namespace backend\controllers;

use backend\helper\MovieHelper;
use backend\models\FilmChoiceUser;
use backend\models\FrontUser;
use backend\models\Movie;
use backend\models\MovieOnlineResource;
use backend\models\UserToken;
use backend\modules\movie\services\MovieListService;
use common\services\StatisticsService;
use Yii;

/*}}}*/

/**
 * ApiController class file.
 * @Author haoliang
 * @Date 20.05.2016 16:02
 */
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
                        'update-zhan','movie-resource','push','report','stat-daily'
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

    public function actionStatDaily(){
        //
        $len = strlen($this->statisticsService->getDailyCount());
        $bin = '';
        for($i = 0; $i < $len; $i ++)
        {
            $bin .= strlen(decbin(ord($this->statisticsService->getDailyCount()[$i])))<8?str_pad(decbin(ord($this->statisticsService->getDailyCount()[$i])),8,0,STR_PAD_LEFT):decbin(ord($this->statisticsService->getDailyCount()[$i]));
        }
        var_dump($bin);
//        echo($this->statisticsService->getDailyCount());
    }
    /*
     * 测试 这个字符串是push()返回的msg_id
     * */
    public function actionReport(){

        return Yii::$app->JPush->report('2011677591');

    }


}
