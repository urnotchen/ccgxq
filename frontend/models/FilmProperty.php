<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/22
 * Time: 18:26
 */
namespace frontend\models;
class FilmProperty extends \common\models\FilmProperty{

    /*
     * 获取官方推荐电影id列表
     * */
    public static function getRecommendOfficialIds(){

        return self::find()->select('movie_id')->where(['property' => self::PROPERTY_RECOMMEND_OFFICIAL])->column();
    }
}