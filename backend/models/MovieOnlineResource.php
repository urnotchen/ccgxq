<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/19
 * Time: 17:52
 */

namespace backend\models;

class MovieOnlineResource extends \common\models\MovieOnlineResource{

    public static function record($arr){

        foreach($arr['definition'] as $eachDefinition) {

            $res = self::findOne(['movie_id' => $arr['movie_id'], 'definition' => $eachDefinition]);

            if (!$res) {
                $record = new self;
                $record->movie_id = $arr['movie_id'];
                $record->definition = $eachDefinition;
                $record->save();
            }
        }
        //如果电影有资源 并且在热门新片列表 自动加入最新列表
        $res = FilmProperty::getProperty(FilmProperty::PROPERTY_HOT,$arr['movie_id']);
        if($res){
            $newestProperty = FilmProperty::getProperty(FilmProperty::PROPERTY_NEWEST,$arr['movie_id']);
            if($newestProperty) {
                $res->delete();
            }else{
                $res->property = FilmProperty::PROPERTY_NEWEST;
                $res->save();
            }
        }
        $movie = Movie::findOne(['id' => $arr['movie_id']]);
        if($movie){
            $movie->resource = Movie::RESOURCE_YES;
            $movie->save();
        }
    }

    /*
     * 获取只有资源没有豆瓣详情的电影Id列表
     * return @params array
     * */
    public static function getNoMovieIds($beginAt,$endAt){

        $beginAt = 0;
        $endAt = time();
        return self::find()
            ->select('movie_id')
            ->where(['between','created_at',$beginAt,$endAt - 1])
            ->andWhere(['not',['movie_id' => Movie::getIds()]])
            ->column();
    }
}