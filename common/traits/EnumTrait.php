<?php

namespace common\traits;

use yii\helpers\ArrayHelper;

/**
 * EnumTrait class file.
 * for model
 * @Author haoliang
 * @Date 12.05.2015 20:18
 */
trait EnumTrait
{

    public static function enum($attr = null, $key = null)
    {
        $enum = static::getEnumData();

        if (empty($enum)){
            return null;
        }

        if ($attr === null){
            return $enum;
        }

        if (!isset($enum[$attr])){
            return null;
        }

        if ($key === null){
            return $enum[$attr];
        }

        return ArrayHelper::getValue($enum[$attr], $key);
    }

    public static function getEnumData()
    {
        return [];
    }

}
