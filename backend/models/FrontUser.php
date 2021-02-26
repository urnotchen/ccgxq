<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/28
 * Time: 11:20
 */

namespace backend\models;


class FrontUser extends \common\models\FrontUser {
    public static function getUserTotal() {

        return static::find()->count();
    }

}