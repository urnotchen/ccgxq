<?php
namespace common\helpers;
/**
 * Created by PhpStorm.
 * User: WangSai
 * Date: 2016/11/25 0025
 * Time: 10:11
 */
class Math
{
    /**
     * 除法，若除数为0，则结果为0
     * @param $dividend
     * @param $divisor
     * @param int $precision
     * @return float|int
     */
    public static function division($dividend, $divisor, $precision = 0)
    {
        return $divisor ? round ($dividend / $divisor, $precision) : 0;
    }

}