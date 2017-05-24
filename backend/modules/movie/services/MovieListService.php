<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/22
 * Time: 10:25
 */

namespace backend\modules\movie\services;

use backend\modules\movie\models\Movie;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\FilmProperty;
use backend\modules\movie\models\MovieIndex;

class MovieListService extends  \common\services\MovieListService{

    public function movieList($property, $query = null)
    {
        if($query == null){
            $query = Movie::find();
        }
        switch ($property) {
            case FilmProperty::PROPERTY_NEWEST:
                $query = $query->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                    ->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->propertyNewestSequence();
                break;
            case FilmProperty::PROPERTY_SELECTED:
                $query = $query->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                    ->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->releaseTimestampSequence();
                break;
            case FilmProperty::PROPERTY_HOT:
                $query = $query->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            case FilmProperty::PROPERTY_RECOMMEND_OFFICIAL:
                $query = $query->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            default :
                throw new \yii\web\HttpException(
                    400, "movie list doesn't have this property",
                    \common\components\ResponseCode::INVALID_MOVIE_LIST_PROPERTY
                );
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ]
        ]);
        return $dataProvider;
    }
}