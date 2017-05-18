<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\forms\MovieDetailsForm;
use frontend\modules\v1\models\forms\MovieListForm;
use frontend\modules\v1\models\forms\MovieListCommonTimeline;
use frontend\modules\v1\models\forms\MovieListNewestTimeline;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\models\MovieIndex;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\Query;


class MovieController extends \frontend\components\rest\Controller
{

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

        if($rawParams['type'] == FilmProperty::PROPERTY_NEWEST){

            $query = Movie::find()->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                ->join('left join',FilmProperty::tableName(),Movie::tableName().'.id='.FilmProperty::tableName().'.movie_id')
                ->where(['or', ['property' => $rawParams['type']], ['property' => null]])
                ->orderBy('film_property.sequence DESC,film_property.created_at DESC,movie_index.create_at DESC,movie.release_timestamp DESC');

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => 10,
                ]
            ]);
            return $dataProvider;

        }else{

            $query = Movie::find()->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                ->where(['or', ['property' => $rawParams['type']], ['property' => null]])
                ->orderBy('film_property.sequence DESC,film_property.created_at DESC,movie.release_timestamp DESC');


            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => 10,
                ]
            ]);

            return  $dataProvider;
        }
    }


    public function actionMovieDetails(){

        $rawParams = Yii::$app->getRequest()->get();

        $form = new MovieDetailsForm();

//        $movie = $form->prepare($rawParams);

        return  Movie::findOneOrException(['id' => $rawParams['id']]);
    }

//    public function actionMovieList()
//    {
//
//        $rawParams = Yii::$app->getRequest()->get();
//        $form = new MovieListForm;
//        $form->prepare($rawParams);
//
//        if($rawParams['type'] == FilmProperty::PROPERTY_NEWEST){
//            return  MovieListNewestTimeline::timeline($rawParams,function($query) use ($rawParams){
//                //写在这里的orderby会失效
//
//                    //todo 太复杂 后面再完善
////                $query->join('join',MovieIndex::tableName(),Movie::tableName().'.id='. MovieIndex::tableName().'.douban' );
////                $query2 = (new Query())->select('*')->from('movie_index')->join('join',Movie::tableName(),MovieIndex::tableName().'.imdb='.Movie::tableName().'.imdb_title');
//                    $query->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')->join('left join',FilmProperty::tableName(),Movie::tableName().'.id='.FilmProperty::tableName().'.movie_id')->where(['or', ['property' => $rawParams['type']], ['property' => null]]);
//
//            });
//        }else{
//            return  MovieListCommonTimeline::timeline($rawParams,function($query) use ($rawParams) {
//                $query->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')->where(['or', ['property' => $rawParams['type']], ['property' => null]]);
//            });
//        }
//
//
//    }

}

?>