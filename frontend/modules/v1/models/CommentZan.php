<?php

namespace frontend\modules\v1\models;

class CommentZan extends \frontend\models\CommentZan
{
    public function fields()
    {
        return [
            'id',
            'status' => function($model){
                if($model->status == self::ZAN_YES) return 1;
                if($model->status == self::ZAN_CANCEL) return 0;
                return null;
            },
        ];
    }
    public static function existZan($user_id,$comment_id){

        return self::findOne(['user_id' => $user_id,'comment_id' => $comment_id,'status' => self::ZAN_YES]);
    }

    public static function zan($comment_id,$action){

        $user_id = \Yii::$app->getUser()->id;

        $zan = self::findOne(['user_id' => $user_id,'comment_id' => $comment_id]);
        if($zan){
            if($action == self::ACTION_ZAN_CANCEL){
                $zan->status = self::ZAN_CANCEL;
                //更改评论的点赞数量
                FilmComment::changeZanNum($comment_id,-1);
            }else{
                $zan->status = self::ZAN_YES;
                //更改评论的点赞数量
                FilmComment::changeZanNum($comment_id,1);
            }
        }else{
            if($action == self::ACTION_ZAN_YES) {
                $zan = new static;
                $zan->comment_id = $comment_id;
                $zan->user_id = $user_id;
                $zan->status = self::ZAN_YES;
                FilmComment::changeZanNum($comment_id, 1);
            }else{
                throw new \yii\web\HttpException(
                    404,
                    'user does not like this comment , can not canceled',
                    \common\components\ResponseCode::INVALID_ZAN_CANCEL
                );
            }
        }

        $zan->save();

        return $zan;
    }
}
