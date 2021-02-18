<?php

namespace common\models;

/**
 * Class StatWeekly
 * @package common\models
 *
 * @property integer $id
 * @property integer $week
 * @property integer $count
 */
class StatWeekly extends \yii\db\ActiveRecord
{
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    protected static $_thisWeek;

    public static function tableName()
    {
        return 'stat_weekly';
    }

    public function rules()
    {
        return [
            [['week', 'count'], 'integer'],
            ['week', 'required'],
            ['week', 'unique'],
            ['count', 'default', 'value' => 0],
        ];
    }

}