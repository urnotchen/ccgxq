<?php

namespace frontend\models;

class Book extends \common\models\Book{

    /*
     * 为个人空间提供数据
     * */
    public static function getBooks(){

        $res = self::find()->where(['created_by' => \Yii::$app->user->id])->orderBy('created_at desc')->all();
        $tmp = [];
        foreach ($res as $one){
            $arr = [];
            $arr['order_name'] = $one->order->name;
            $arr['order_id'] = $one->order->id;
            $arr['book_time'] = date("Y-m-d H:i",7 * 3600 +$one['book_begin_time']).'-'.date("H:i",7 * 3600 + $one['book_end_time']);
            $arr['status'] = self::enum('status')[$one['status']];
            $arr['address'] =  $one->order->address;
            $tmp[] = $arr;
        }
        return $tmp;
    }
}