<?php

namespace backend\models;

class FilmComment extends \common\models\FilmComment{

    /*
     * 获取用户短评(有内容的)数
     * */
    public static function getCommentNum($userId){

        return self::find()
            ->where(['type' => self::TYPE_USER,'user_id' => $userId])
            ->andWhere(['not',['comment' => null]])
            ->count();
    }
}
