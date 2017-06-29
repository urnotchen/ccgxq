<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/28
 * Time: 11:21
 */

namespace backend\models;

class FilmChoiceUser extends \common\models\FilmChoiceUser{

    /*
     * 把推送过的电影状态改为已推送
     * */
    public static function pushed($userId){

        self::updateAll(['push' => self::PUSH_YES],['user_id' => $userId,'type' => self::TYPE_SUBSCRIBE,'status' => self::STATUS_NORMAL,'push' => self::PUSH_NO]);

    }

}