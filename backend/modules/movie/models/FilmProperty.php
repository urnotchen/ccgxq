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

    /*
     * 获取所有位置在当前元素之上的元素
     * */
    public static function getGtSequenceItems($property,$sequence){

        return self::find()->where(['property' => $property])->andWhere(['>', 'sequence', $sequence])
            ->orderBy(['sequence' => SORT_ASC])->all();
    }
    /*
     * 获取所有位置在当前元素之下的元素
     * */
    public static function getLtSequenceItems($property,$sequence){

        return self::find()->where(['status' => FilmProperty::STATUS_NORMAL,'property' => $property])->andWhere(['<', 'sequence', $sequence])
            ->orderBy(['sequence' => SORT_DESC])->all();
    }

    /*
     * 获取某列表有顺序的元素
     * */
    public static function getHaveSequenceItems($property){

        return self::find()->where(['status' => FilmProperty::STATUS_NORMAL,'property' => $property])->andWhere(['>','sequence',0])->orderBy(['sequence' => SORT_ASC])->all();
    }

}