<?php
namespace frontend\models;

class FrontUser extends \common\models\FrontUser{
    /*
     * 用户个人空间准备数据
     * */
    public static function getInfo(){

        $user = self::findOne(\Yii::$app->user->id);

        return $user;
    }
}