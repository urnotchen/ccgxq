<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/16
 * Time: 9:44
 */

namespace backend\models;

use common\models\BaseUser;
use common\traits\KVTrait;

class User extends \common\models\BaseUser{
    use KVTrait;
}