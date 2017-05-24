<?php

namespace frontend\modules\v1\models;

class CommentZan extends \frontend\models\CommentZan
{
    public function fields()
    {
        return [
            'id',
            'status',
        ];
    }
    public static function existZan($user_id,$comment_id){

        return self::findOne(['user_id' => $user_id,'comment_id' => $comment_id,'status' => self::ZAN_YES]);
    }

    public static function zan($user_id,$comment_id){

        $zan = self::findOne(['user_id' => $user_id,'comment_id' => $comment_id]);
        if($zan){
            if($zan->status == self::ZAN_YES){
                $zan->status = self::ZAN_CANCEL;
            }else{
                $zan->status = self::ZAN_YES;
            }
        }else{
            $zan = new static;
            $zan->comment_id = $comment_id;
            $zan->user_id = $user_id;
            $zan->status = self::ZAN_YES;
        }

        $zan->save();
        return $zan;
    }
}
