<?php

namespace backend\modules\movie\models;

class FilmProperty extends \backend\models\FilmProperty{

    /*
     * 更新电影斩(定时)
     * */
    public static function updateZhan($movieIdList){

        foreach($movieIdList as $eachMovieId){
            $movieProperty = self::findOne(['movie_id' => $eachMovieId,'property' => self::PROPERTY_RECOMMEND_OFFICIAL]);
            if($movieProperty){
                if($movieProperty->status == self::STATUS_NORMAL){
                    continue;
                }else{
                    $movieProperty->status = self::STATUS_NORMAL;
                }
            }else{
                $movieProperty = new static;
                $movieProperty->movie_id = $eachMovieId;
                $movieProperty->status = self::STATUS_NORMAL;
                $movieProperty->sequence = 0;
                $movieProperty->property = self::PROPERTY_RECOMMEND_OFFICIAL;
                $movieProperty->created_by = 0;
                $movieProperty->updated_by = 0;
            }
            $movieProperty->save();
        }
    }
}