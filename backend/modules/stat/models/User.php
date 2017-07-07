<?php

namespace backend\modules\stat\models;


class User extends \backend\models\FrontUser
{
    public static function getIncrementYesterday()
    {
        $today = \Yii::$app->dateFormat->getTodayTimestamp();

        return self::find()->where([
            'between', 'created_at', $today - 24 * 3600, $today - 1
        ])->count();
    }
}

?>