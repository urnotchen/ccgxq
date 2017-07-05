<?php

namespace common\models;

/**
 * Class StatDaily
 * @package common\models
 *
 * @property integer $id
 * @property integer $day
 * @property integer $count
 * @property string $daily
 */
class StatDaily extends \yii\db\ActiveRecord
{
    use \common\traits\KVTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    const MINUTE = 60, HOUR = 3600, DAY = 86400;

    protected static $_today;

    public static function tableName()
    {
        return 'stat_daily';
    }

    public function rules()
    {
        return [
            [['day', 'count'], 'integer'],
            ['daily', 'string'],
            ['day', 'required'],
            ['day', 'unique'],
            ['count', 'default', 'value' => 0],
        ];
    }

    public static function buildDailyStatKey($timestamp = -1)
    {
        return "sb_dau_" . ($timestamp == -1 ? \Yii::$app->dateFormat->getTodayTimestamp() : $timestamp);
    }

    /**
     * 用户统计
     *
     * @param $userId
     */
    public static function dailyStat($userId)
    {
        //日数据保存32天
        \Yii::$app->redis->setbit(self::buildDailyStatKey(), $userId, 1);
        \Yii::$app->redis->expire(self::buildDailyStatKey(), self::DAY*38);
    }
}