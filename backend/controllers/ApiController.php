<?php

namespace backend\controllers;

use backend\helper\MovieHelper;
use backend\models\FilmChoiceUser;
use backend\models\FrontUser;
use backend\models\Movie;
use backend\models\MovieOnlineResource;
use backend\models\UserToken;
use backend\modules\movie\services\MovieListService;
use Yii;

/*}}}*/

/**
 * ApiController class file.
 * @Author haoliang
 * @Date 20.05.2016 16:02
 */
class ApiController extends \yii\rest\Controller
{

    public $_service;

    public function behaviors()
    {/*{{{*/
        $inherit = parent::behaviors();

        $inherit['contentNegotiator']['formats']['application/xml'] = \yii\web\Response::FORMAT_JSON;
        $inherit['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;

        $inherit['access'] = ['class' => \yii\filters\AccessControl::className(),
            'rules' => [
                [
                    'actions' => [
                        'update-zhan','movie-resource','push'
                    ],
                    'allow' => true,
                    'roles' => ['?'],
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

//            $userRegistrationIds = UserToken::getRegistrationIds($userId);
//
//            foreach($userRegistrationIds as $eachUserRegistrationId){
//
            Yii::$app->JPush->send($registrationId,$content);
//
//            }

            FilmChoiceUser::pushed($userId);
        }
        return $pushIds;
    }
}
