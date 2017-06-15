<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\forms\MovieDetailsForm;
use frontend\modules\v1\models\forms\MovieListForm;
use frontend\modules\v1\models\forms\UserChoiceListForm;
use frontend\modules\v1\models\forms\UserStarSawListForm;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\services\MovieListService;
use Yii;
use yii\data\ActiveDataProvider;



class SearchController extends \frontend\components\rest\Controller
{

    protected $_service;

    public function behaviors()
    {
        $inherit = parent::behaviors();

//        $inherit['authenticator']['only'] = [
//
//        ];
        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];



        return $inherit;
    }
    public function verbs()
    {
        return [
            'keyword'    => ['get'],

        ];
    }
    /*
     * 搜索关键字
     * */
    public function actionKeyword()
    {

        $rawParams = Yii::$app->getRequest()->get();
//        $form = new MovieListForm;
//        $form->prepare($rawParams);

        $dataProvider = $this->getService()->keyword($rawParams);

        return $dataProvider;
    }

    /*
     * 暂时不用
     * */
    public function actionMovieDetails(){

        $rawParams = Yii::$app->getRequest()->get();

        $form = new MovieDetailsForm();

        return  Movie::findOneOrException(['id' => $rawParams['id']]);
    }

    /*
     * 用户看过/想看/订阅列表
     * */
    public function actionUserChoiceList(){

        $rawParams = Yii::$app->getRequest()->get();

        $form = new UserChoiceListForm();
        $form->prepare($rawParams);

        return $this->service->userChoiceList(Yii::$app->getUser()->id,$form->type);

    }

    /*
     * 用户通过自评分搜索自己看过的电影列表
     * */
    public function actionUserStar(){

        $rawParams = Yii::$app->getRequest()->get();
        $form = new UserStarSawListForm();
        $form->prepare($rawParams);
        return $this->service->userStarSawList($rawParams,Yii::$app->getUser()->id);

    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new MovieListService();
        }

        $this->getUser();

        return $this->_service;
    }

}

?>