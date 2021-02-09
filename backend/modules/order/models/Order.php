<?php
namespace backend\modules\order\models;

class Order extends \backend\models\Order {


    /*
     * 获取所有可预约的项目
     *
     * */
    public static function getOrdersForCrontab(){

        return self::find()->where(['status' => self::STATUS_NORMAL])->all();
    }
}