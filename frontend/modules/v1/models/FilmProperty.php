<?php

namespace frontend\modules\v1\models;

class FilmProperty extends \frontend\models\FilmProperty{

    /*
     * 属性列表是否有变化(为缓存依赖所使用)
     * */
    public static function isChanged($property){

        return self::find()->where(['property' => $property,'status' => self::STATUS_NORMAL])->orderBy(['sequence' => SORT_DESC])->createCommand()->getRawSql();
    }

    /*
     * 判断某部电影有无某个属性
     * */
    public static function existProperty($movieId,$property){

        $res = self::findOne(['movie_id' => $movieId,'property' => $property,'status' => self::STATUS_NORMAL]);
        return $res?1:0;
    }
}