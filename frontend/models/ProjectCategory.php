<?php
namespace  frontend\models;


class ProjectCategory extends \common\models\ProjectCategory {


    /*
     * 为前台首页准备数据
     *
     * */
    public static function getPersonalCategories($keyword = null , $num = null)
    {

        $query = self::find()->select(['id', 'name'])->where(['status' => self::STATUS_NORMAL, 'category_id' => self::CATEGORY_PERSONAL]);
        if ($keyword)
            $query->andWhere(['like', 'name', $keyword]);
        if ($num)
            $query->limit($num);

        $res = $query->orderBy('created_at desc')->all();
        $arr = [];
        foreach ($res as $one) {
            $tmp['id'] = $one['id'];
            $tmp['name'] = $one['name'];
            $arr[] = $tmp;
        }
        return $res;
    }
    /*
     * 为前台首页准备数据
     *
     * */
    public static function getCompanyCategories($keyword = null , $num = null)
    {

        $query = self::find()->select(['id', 'name'])->where(['status' => self::STATUS_NORMAL, 'category_id' => self::CATEGORY_COMPANY]);
        if ($keyword)
            $query->andWhere(['like', 'name', $keyword]);
        if ($num)
            $query->limit($num);

        $res = $query->orderBy('created_at desc')->all();
        $arr = [];
        foreach ($res as $one) {

            $tmp['id'] = $one['id'];
            $tmp['name'] = $one['name'];
            $arr[] = $tmp;
        }
        return $arr;
    }

}