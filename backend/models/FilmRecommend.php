<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/4/26
 * Time: 15:12
 */
namespace backend\models;

class FilmRecommend extends \common\models\FilmRecommend{


    /*
     * 获取关联推荐表中推荐的电影没有详情的电影id列表,限制为1000部
     * */
    public static function getNoRecommendIds(){

        return self::find()->select('recommend_movie_id')->where(['not',['recommend_movie_id' => Movie::getAllIds()]])->andWhere(['id' => 0])->groupBy('recommend_movie_id')->limit(1000)->column();

    }
}