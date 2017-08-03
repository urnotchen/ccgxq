<?php

namespace backend\modules\stat\models;

class StatDaily extends \backend\models\StatDaily
{
    /**
     * 日活跃用户，不包含新注册的用户。统计7日内刨去注册登录的用户的平均数。
     *
     * @return float|int
     */
    public static function getStatDaily()
    {
        $sevenDayBegin = strtotime(date('Y-m-d', strtotime('-7 day')));
        $sevenDayEnd = strtotime(date('Y-m-d')) - 1;

        return round(self::find()->where([
            'between', 'day', $sevenDayBegin, $sevenDayEnd
        ])->sum('count')/7);
    }

    public static function getRangeStatDaily($begin, $end)
    {
        $models = self::find()->where([
                'between' , 'day', $begin, $end
        ])->all();

        return [
            \yii\helpers\ArrayHelper::getColumn($models, function (self $model) {
                return \Yii::$app->dateFormat->humanReadableDate($model->day);
            }),
            \yii\helpers\ArrayHelper::getColumn($models, function (self $model) {
                return $model->count;
            }),
        ];
    }
}

?>