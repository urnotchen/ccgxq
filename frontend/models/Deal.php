<?php
namespace frontend\models;

class Deal extends \common\models\Deal{

    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_NORMAL => '待处理',
            ],

        ];
    }
    /*
     * 将用户上传的
     *
     * */

    public static function addRecord($approval_id,$file_arr,$label_arr){

        $deal = new self();
        $deal['approval_id'] = $approval_id;
        $deal['file_arr'] = $file_arr;
        $deal['label_arr'] = $label_arr;
         $deal->save();
    }
    /*
     * 为用户空间提供数据
     *
     * */
    public static function getDeals(){

        $res = self::find()->where(['created_by' => \Yii::$app->user->id])->all();
        $tmp = [];
        foreach ($res as $key => $val){
            $arr = [];
            $arr['status'] = self::enum('status')[$val['status']];
            $arr['approval_name'] = $val->approval->name;
            $arr['approval_id'] = $val['approval_id'];
            $arr['created_at'] = date("Y-m-d",$val['created_at']);
            $tmp[] = $arr;
        }
        return $tmp;
    }
}