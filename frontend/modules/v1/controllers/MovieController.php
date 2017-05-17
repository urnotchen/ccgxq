<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\forms\MovieListForm;
use frontend\modules\v1\models\forms\MovieTimeline;
use frontend\modules\v1\models\Movie;
use Yii;
use yii\db\Exception;


class MovieController extends \frontend\components\rest\Controller
{

    public function verbs()
    {
        return [
            'movie-list'    => ['get']
        ];
    }

    public function actionMovieList()
    {

        $rawParams = Yii::$app->getRequest()->get();
        $form = new MovieListForm;
        $form->prepare($rawParams);

        return  MovieTimeline::timeline($rawParams,function($query) use ($rawParams){
//            $query->join('join',FilmProperty::tableName(),Movie::tableName().'.id='. FilmProperty::tableName().'.movie_id' )->andWhere(["property" => $rawParams['type']]);
            $query->join('left join',FilmProperty::tableName(),Movie::tableName().'.id='. FilmProperty::tableName().'.movie_id' )->where(['or',['property' => $rawParams['type']],['property' => null]])->orderBy(['film_property.sequence' => SORT_DESC]);
        });

    }

}

?>