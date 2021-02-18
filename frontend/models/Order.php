<?php
namespace frontend\models;
class Order extends \common\models\Order{



    public static function getOrderList(){

        $res = self::find()->all();

        foreach ($res as $key => $val){
            $res[$key]['img'] = APP_DOMAIN_SCHEMA.APP_BACK_BASE_DOMAIN.$val['img'];
            $res[$key]['position_id'] = self::enum('position')[$val['position_id']];

        }
        $res[$key]['afternoon_time'] = '周一至周五 上午：'.$val['morning_time'].' 下午：'.$val['afternoon_time'];
        return $res;
    }


}