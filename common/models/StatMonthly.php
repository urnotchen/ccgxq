<?php

namespace common\models;

/**
 * Class StatMonthly
 * @package common\models
 *
 * @property integer $id
 * @property integer $month
 * @property integer $count
 */
class StatMonthly extends \yii\db\ActiveRecord
{
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    protected static $_thisMonth;

    public static function tableName()
    {
        return 'stat_monthly';
    }

    public function rules()
    {
        return [
            [['month', 'count'], 'integer'],
            ['month', 'required'],
            ['month', 'unique'],
            ['count', 'default', 'value' => 0],
        ];
    }

}