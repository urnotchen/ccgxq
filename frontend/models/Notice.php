<?php

namespace frontend\models;


use yii\base\InvalidConfigException;

class Notice extends  \common\models\Notice {

    /**
     * @param $key
     * @param $value1
     * @param $value2
     * @param array $condition
     * @return array
     * @throws InvalidConfigException
     */
    public static function getNotices($cate_id,$keyword = null,$num = null){
        $query = self::find()->select(['id','title','created_at'])->where(['status' => self::STATUS_NORMAL,'cate_id' => $cate_id]);
        if($keyword)
            $query->andWhere(['like','title',$keyword]);
        if($num)
            $query->limit($num);

        $res = $query->orderBy('created_at desc')->all();
        $arr = [];
        foreach ($res as $one){
            $tmp['url']='view?id='.$one['id'];
//            $tmp['title'] = mb_substr($one['title'],0,20);
            $tmp['id'] = $one['id'];
            $tmp['title'] = $one['title'];
            $tmp['created_at'] = \Yii::$app->timeFormatter->normalYmd($one['created_at']);
            $arr[] = $tmp;
        }
        return $arr;
    }
}