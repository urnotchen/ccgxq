<?php

namespace backend\modules\stat\models;

class StatMonthly extends \backend\models\StatMonthly
{
    /**
     * 月活用户，在一个月内超过4天同步过数据的用户。
     * 其中倒数第二次登录时间减去30天内第一次登陆时间应大于七天
     * 必须有2天是7天以后的才行
     *
     * @return int
     */
    public static function getStatMonthly()
    {
        $model = self::findOne(['month' => \Yii::$app->dateFormat->getThisMonthTimestamp()]);

        return empty($model) ? 0 : $model->count;
    }
}

?>