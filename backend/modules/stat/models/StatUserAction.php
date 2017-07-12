<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/7/12
 * Time: 18:30
 */

namespace backend\modules\stat\models;

class StatUserAction extends \backend\models\StatUserAction{

    public static function getRangeStatComment($begin, $end)
    {
        $models = self::find()
            ->where(['type' => self::TYPE_COMMENT])
            ->andWhere(['between' , 'day', $begin, $end])
            ->all();

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