<?php
namespace frontend\models;

class Message extends \common\models\Message{


    /*
     * 为个人空间提供数据
     *
     * */
    public static function getMessages(){

        $res = self::find()->where(['created_by' => \Yii::$app->user->id])->all();

        foreach ($res as $key => $one){
            $res[$key]['created_at'] = date("Y-m-d",$one['created_at']);
            $res[$key]['status'] = self::enum('status')[$one['status']];
        }
        return $res;
    }
}