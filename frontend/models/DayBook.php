<?php

namespace frontend\models;

class DayBook extends \common\models\DayBook{


    const OPERATION_BOOK = 1,OPERATION_CANCEL = 2;
    /*
     * 根据日期和预约项目id寻找当天当项目的预约表
     * */
    public static function findByTimeByOrderId($order_id,$timestamp){

        return self::find()->where(['order_id' => $order_id,'day_time' => $timestamp])->one();
    }

    /*
     * 增加、取消预约时，预约总表的变化
     * */
    public static function updateRecord($operation,$day_book_id,$book_time_arr_val){

        $day_book = self::findOne($day_book_id);
        $book_num_arr = json_decode($day_book['book_num_arr']);
        $book_time_arr = json_decode($day_book['book_time_arr']);
        if($operation == self::OPERATION_BOOK){
            $book_num_arr[$book_time_arr_val]++;
            $day_book['book_num'] = $day_book['book_num'] + 1;
            if($day_book['book_num'] >= $day_book['book_total']){
                $day_book['status'] = self::STATUS_OVER;
            }
            $day_book['book_num_arr'] = json_encode($book_num_arr);
        }
        if($operation == self::OPERATION_CANCEL){
            $book_num_arr[$book_time_arr_val]--;
            $day_book['book_num'] = $day_book['book_num'] -1;
            $day_book['book_num_arr'] = json_encode($book_num_arr);
            if($day_book['status'] == self::STATUS_OVER){
                $day_book['status'] = self::STATUS_NORMAL;
            }
        }
        $day_book->save();
    }


}