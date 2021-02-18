<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/7/4
 * Time: 15:35
 */

namespace backend\helper;

use yii\base\Object;

class BasicHelper extends Object{

    /*
     * 字符串转二进制字符串
     * */
    public static function strToBinStr($str){
        $len = strlen($str);
        $bin = '';
        for($i = 0; $i < $len; $i ++)
        {
            $bin .= strlen(decbin(ord($str[$i])))<8?str_pad(decbin(ord($str[$i])),8,0,STR_PAD_LEFT):decbin(ord($str[$i]));
        }
        var_dump($bin);
    }
}