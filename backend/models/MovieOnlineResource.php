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