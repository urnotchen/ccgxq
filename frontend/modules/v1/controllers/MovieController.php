<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\Movie;

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
        return (Movie::find()->limit(10)->all());
    }

}

?>