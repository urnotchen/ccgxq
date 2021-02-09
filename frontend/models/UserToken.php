<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/28
 * Time: 11:45
 */

namespace backend\models;

class UserToken extends \common\models\UserToken{

    /*
     * 获取用户的所有极光id
     * @return array
     * */
    public static function getRegistrationIds($userId){

        return self::find()->select('registration_id')->where(['user_id' => $userId])->column();

    }
}