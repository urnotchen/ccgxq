<?php
namespace  frontend\models;



class Project extends \common\models\Project {


    /*
     * 为前台首页准备数据
     *
     * */
    public static function getProjectsByCategoryId($id)
    {

        $query = self::find()->select(['id','name','sszt'])->where(['project_category_id' => $id,'status' => self::STATUS_NORMAL]);


        $res = $query->orderBy('created_at desc')->all();
        $arr = [];

        foreach ($res as $one) {
            $tmp['id'] = $one['id'];
            $tmp['sszt'] = $one['sszt'];
            $tmp['name'] = $one['name'];
            $arr[] = $tmp;
        }
        return $arr;
    }
}