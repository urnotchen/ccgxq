<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/4/26
 * Time: 15:14
 */

namespace backend\modules\movie\models;

class FilmTypeConn extends \backend\models\FilmTypeConn{

    /*
     * 根据类型电影数量排序,获取类型列表
     * */
    public static function getTopTypes(){

        return self::find()->select(['count(type_id) as num', 'type_id'])->groupBy('type_id')->orderBy(['num' => SORT_DESC])->asArray()->all();
    }
}