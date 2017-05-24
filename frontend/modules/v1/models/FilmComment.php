<?php

namespace frontend\modules\v1\models;

use frontend\modules\v1\behaviors\AddRecommendUserBehavior;
use frontend\modules\v1\behaviors\AddUserChoiceBehavior;

class FilmComment extends \frontend\models\FilmComment
{

    use \common\traits\FindOrExceptionTrait;
    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;
    use \common\traits\SaveExceptionTrait;

    const PERMIT_COMMENT_YES = 1 , PERMIT_COMMENT_NO = 2;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['addRecommendUser'] =[
            'class' => AddRecommendUserBehavior::className(),
            'comment' => $this,
        ];
        $behaviors['addUserChoice'] =[
            'class' => AddUserChoiceBehavior::className(),
            'comment' => $this,
        ];
        return $behaviors;
    }

    public function fields()
    {
        return [
            'id' => function($model){
                return (int)$model->id;
            },
            'star',
            'good_num',
            'comment',
            'username' => function($model){
                if($model->username){
                    return $model->username;
                }else{
                    //todo 返回用户名
//                    return
                }
            },
            'source' => function($model){
                return $model->type;
            }
        ];
    }

    public function extraFields()
    {
        return [
            'image',
        ];
    }

    public function getImage(){
        return $this->hasOne(Image::className(),['id' => 'pic_id']);
    }

    /*
     * 是否允许评论
     * */
    public static function permitComment($movie_id,$user_id){

        return self::find()->where(['movie_id' => $movie_id,'user_id' => $user_id])?self::PERMIT_COMMENT_NO:self::PERMIT_COMMENT_YES;
    }

    /*
     * 添加评论
     * */
    public static function addComment($userComment,$user_id){

        $comment = new static;
        $comment->setAttributes([
            'user_id'         => $user_id,
            'star'            => $userComment->star,
            'movie_id'        => $userComment->movie_id,
            'comment'         => $userComment->content,
        ]);
        if($comment->save()){
            return $comment;
//        }else{
//            throw new HttpE
        }

    }
}
