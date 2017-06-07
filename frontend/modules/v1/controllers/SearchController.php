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

    public function actionKeyword()
    {

        $rawParams = Yii::$app->getRequest()->get();
//        $form = new MovieListForm;
//        $form->prepare($rawParams);


        $dataProvider = $this->getService()->keyword($rawParams);

        return $dataProvider;
    }


    public function actionMovieDetails(){

        $rawParams = Yii::$app->getRequest()->get();

        $form = new MovieDetailsForm();

//        $movie = $form->prepare($rawParams);

        return  Movie::findOneOrException(['id' => $rawParams['id']]);
    }

    public function actionUserChoiceList(){

        $rawParams = Yii::$app->getRequest()->get();

        $form = new UserChoiceListForm();
        $form->prepare($rawParams);

        return $this->getService()->userChoiceList(Yii::$app->getUser()->id,$form->type);

    }

    public function actionUserStar(){

        $rawParams = Yii::$app->getRequest()->get();
        $form = new UserStarSawListForm();
        $form->prepare($rawParams);
        return $this->getService()->userStarSawList($rawParams,Yii::$app->getUser()->id);

    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new MovieListService();
        }

        return $this->_service;
    }

}

?>