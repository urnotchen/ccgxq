<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\forms\MovieDetailsForm;
use frontend\modules\v1\models\forms\MovieListForm;
use frontend\modules\v1\models\forms\UserChoiceListForm;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\services\MovieListService;
use Yii;
use yii\data\ActiveDataProvider;



class MovieController extends \frontend\components\rest\Controller
{

    protected $_service;

    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['only'] = [
            'user-choice-list',
        ];
        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];



        return $inherit;
    }
    public function verbs()
    {
        return [
            'movie-list'    => ['get'],
            'movie-details'    => ['get']
        ];
    }

    public function actionMovieList()
    {

        $rawParams = Yii::$app->getRequest()->get();
        $form = new MovieListForm;
        $form->prepare($rawParams);

//        if($rawParams['type'] == FilmProperty::PROPERTY_NEWEST){
//
//            $query = Movie::find()->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
//                ->join('left join',FilmProperty::tableName(),Movie::tableName().'.id='.FilmProperty::tableName().'.movie_id')
//                ->where(['or', ['property' => $rawParams['type']], ['property' => null]])
//                ->propertyNewestSequence();
//
//        }else{
//
//            $query = Movie::find()->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
//                ->where(['or', ['property' => $rawParams['type']], ['property' => null]])
//               ->propertyCommonSequence();
//
//        }
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => [
//                'defaultPageSize' => 10,
//            ]
//        ]);

        $dataProvider = $this->getService()->movieList($rawParams['type']);

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

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new MovieListService();
        }

        return $this->_service;
    }

}

?>