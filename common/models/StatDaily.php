<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stat_daily".
 *
 * @property integer $id
 * @property integer $day
 * @property integer $count
 * @property integer $type
 * @property string $daily
 */
class StatDaily extends \yii\db\ActiveRecord
{

    use \common\traits\InstanceTrait;

    //类型 日活 周活 月活 短评统计 电影斩标记电影统计
    const TYPE_DAILY = 1 , TYPE_WEEK = 2 , TYPE_MONTH = 3 , TYPE_COMMENT = 4 , TYPE_ZHAN = 5;

    //周活 月活 的计算时间
    const WEEK_ACTIVE_DAY = 1 , MONTH_ACTIVE_DAY = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year','month','week','day', 'count', 'type','begin_at','end_at'], 'required'],
            [['year','month','week','day', 'count', 'type','begin_at','end_at','created_at','updated_at'], 'integer'],
            [['begin_at','end_at'],'unique'],
            [['daily'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'year',
            'month' => 'month',
            'week' => 'week',
            'day' => 'Day',
            'count' => 'Count',
            'type' => 'Type',
            'daily' => 'Daily',
            'begin_at' => 'begin_at',
            'end_at' => 'end_at',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
    }
}
