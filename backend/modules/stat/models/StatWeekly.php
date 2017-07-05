<?php

namespace backend\modules\stat\models;

class StatWeekly extends \backend\models\StatWeekly
{
    /**
     * 周活用户，在一个自然周内容超过(含)2天同步过数据的用户。
     *
     * @return int
     */
    public static function getStatWeekly()
    {
        $model = self::findOne(['week' => \Yii::$app->dateFormat->getThisWeekTimestamp()-7*86400]);

        return empty($model) ? 0 : $model->count;
    }
}

?>