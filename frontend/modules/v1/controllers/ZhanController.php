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
use frontend\modules\v1\models\forms\MovieZhanListForm;
use frontend\modules\v1\services\MovieListService;

use yii\data\ActiveDataProvider;

class ZhanController extends Controller{

    protected $_service;

    public function behaviors()
{
    $inherit = parent::behaviors();

    $inherit['authenticator']['only'] = [
        'index',
    ];
    $inherit['authenticator']['authMethods'] = [
        \frontend\modules\v1\components\AccessTokenAuth::className(),
    ];



    return $inherit;
}

    public function verbs()
    {
        return [
            'index'    => ['get'],
        ];
    }

    /*
     * 官方列表
     * */
    public function actionIndex()
    {

        $rawParams = \Yii::$app->getRequest()->get();

        //是否推荐过电影斩
        if (FilmRecommendUser::yetRecommend($this->getUser()->id)) {
            //已经推荐过了 就推荐个人的
            return $this->getService()->userRecommend($this->getUser()->id);
        } else {
            //没被推荐过 推荐官方的
            return $this->getService()->movieList(FilmProperty::PROPERTY_RECOMMEND_OFFICIAL);
        }

    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new MovieListService();
        }

        return $this->_service;
    }


}