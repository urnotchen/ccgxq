<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/28
 * Time: 11:20
 */

namespace backend\models;

use common\models\User;

class FrontUser extends User{
    public static function getUserTotal() {

        return static::find()->count();
    }

}