<?php
namespace frontend\models;

class Approval extends  \common\models\Approval{


    /*
    * 为前台首页准备数据
    *
    * */
    public static function getApprovalByProjectId($project_id)
    {

        $query = self::find()->where(['project_id' => $project_id,'status' => self::STATUS_NORMAL]);


        $res = $query->orderBy('created_at desc')->one();


        $res['blclml'] = json_decode($res['blclml']);


        return $res;
    }
    /*
    * 为前台首页准备数据
    *
    * */
    public static function getApprovalById($id)
    {

        $res = self::findOne($id);



        $res['blclml'] = json_decode($res['blclml']);


        return $res;
    }
}