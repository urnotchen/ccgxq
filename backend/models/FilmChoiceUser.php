<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/28
 * Time: 11:21
 */

namespace backend\models;

use yii\helpers\ArrayHelper;

class FilmChoiceUser extends \common\models\FilmChoiceUser{

    /*
     * 把推送过的电影状态改为已推送
     * */
    public static function pushed($userId){

        self::updateAll(['push' => self::PUSH_YES],['user_id' => $userId,'type' => self::TYPE_SUBSCRIBE,'status' => self::STATUS_NORMAL,'push' => self::PUSH_NO]);

    }

    /*
     * 获取想看/统计 数量最多的前30部电影
     * */
    public static function getMaxMovieIds($type,$num = 30){

        $res = self::find()
            ->select('movie_id,count(movie_id) as num')
            ->where(['type' => $type,'status' => self::STATUS_NORMAL])
            ->groupBy('movie_id')
            ->orderBy('num desc')
            ->asArray()
            ->all();
        return ArrayHelper::map($res,'movie_id','num');
    }
}