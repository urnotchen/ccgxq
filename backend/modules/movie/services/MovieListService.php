<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/22
 * Time: 10:25
 */

namespace backend\modules\movie\services;

use backend\modules\movie\models\FilmType;
use backend\modules\movie\models\FilmTypeConn;
use backend\modules\movie\models\Movie;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\FilmProperty;
use backend\modules\movie\models\MovieIndex;

class MovieListService extends  \common\services\MovieListService{

    public function movieList($property, &$query = null)
    {


        switch ($property) {
            case FilmProperty::PROPERTY_NEWEST:
                $query->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                    ->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->propertyNewestSequence();
                var_dump($query->createCommand()->getRawSql());
                break;
            case FilmProperty::PROPERTY_SELECTED:
                $query->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                    ->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->releaseTimestampSequence();
                break;
            case FilmProperty::PROPERTY_HOT:
                $query->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            case FilmProperty::PROPERTY_RECOMMEND_OFFICIAL:
                $query->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            default :
                throw new \yii\web\HttpException(
                    400, "movie list doesn't have this property",
                    \common\components\ResponseCode::INVALID_MOVIE_LIST_PROPERTY
                );
        }

    }

    /*
     * 定时更新电影斩
     * */
    public static function updateZhan(){

        //定时更新电影斩的300部电影(有可能不到300部)
        //筛选一下电影类型数量排名前15的类型
        $typeList = FilmTypeConn::getTopTypes();

        //筛选电影斩需要的电影
        $arr = Movie::getMovieZhanIds($typeList,15);

//        $randNumArr = [];
//
//        while(count($randNumArr) != 20){
//            $num = rand(0,count($arr) - 1 );
//            if(in_array($num,$randNumArr)){
//                continue;
//            }else{
//                $randNumArr[] = $num;
//            }
//        }



        //加入到电影斩列表
        FilmProperty::updateZhan($arr);
    }
}