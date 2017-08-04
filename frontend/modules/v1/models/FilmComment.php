<?php

namespace frontend\modules\v1\models;

use frontend\modules\v1\behaviors\AddRecommendUserBehavior;
use frontend\modules\v1\behaviors\AddUserChoiceBehavior;
use frontend\modules\v1\services\StatisticsService;

class FilmComment extends \frontend\models\FilmComment
{

    public $idTemp;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['addRecommendUser'] =[
            'class' => AddRecommendUserBehavior::className(),
            'comment' => $this,
        ];
        $behaviors['updateRecommendUser'] =[
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
                    $user = User::findOne(['id' => $model->user_id]);
                    if($user->userDetails){
                        return $user->userDetails->nickname;
                    }
                    return null;
                }
            },
            'source' => function($model){
                return $model->type;
            },
            'url' => function($model){
                if($model->pic_id){
                    return $model->image->path?\Yii::$app->params['qiniuDomain'].$model->image->path:'';
                }else{
                    $user = UserDetails::findOne($model->user_id);
                    if($user) {
                        return $user->getAvatar();
                    }else{
                        return null;
                    }
                }
            },
            'zan' => function($model){
                return CommentZan::existZan(\Yii::$app->getUser()->id,$model->id)?CommentZan::ZAN_YES:CommentZan::ZAN_CANCEL;
            }
        ];
    }

    public function extraFields()
    {
        return [
          ];
    }

    public function getImage(){
        return $this->hasOne(Image::className(),['id' => 'pic_id']);
    }

    /*
     * 添加评论
     * */
    public static function addComment($userComment,$user_id){

        $comment = self::existComment($userComment->movie_id,$user_id);
        if(!$comment){
            $comment = new static;
        }
        $comment->setAttributes([
            'user_id'         => $user_id,
            'star'            => $userComment->star,
            'movie_id'        => $userComment->movie_id,
            'comment'         => $userComment->content,
            'source'         => $userComment->source,
        ]);
        $comment->save();

        return $comment;

    }

    public static function getUserComment($user_id,$movie_id){

        return FilmComment::findOne((['user_id'=> $user_id,'movie_id' => $movie_id,'type' => FilmComment::TYPE_USER]));

    }

    public static function getCommentListQuery($movie_id){

        return self::find()->select('film_comment.*,(select @rownum:=0)')->where(['movie_id' => $movie_id])->andWhere(['not',['comment' => null]])->typeSequence()->goodNumSequence();

    }
    /*
     * 为电影斩提供前5个评论
     * */
    public static function getCommentFive($movie_id){

        return self::find()->where(['movie_id' => $movie_id])->andWhere(['not',['comment' => null]])->typeSequence()->goodNumSequence()->limit(5)->all();
    }

    /*
     * 点赞数+1 / -1
     * */
    public static function changeZanNum($comment_id,$action){

        $comment = self::findOneOrException(['id' => $comment_id]);

        $comment->good_num += $action;

        $comment->save();
    }

    public static function existComment($movie_id,$user_id){

        $res = self::findOne(['movie_id' => $movie_id,'user_id' => $user_id]);
        return $res;
    }

    /*
     * 获取评论总数
     * */
    public static function getCommentNum($movieId){

        return (int)self::find()->where(['movie_id' => $movieId])->andWhere(['not',['comment' => null]])->count();
    }

    protected function getStatisticsService()
    {
        if ($this->_statisticsService === null) {
            $this->_statisticsService = new StatisticsService();
        }

        return $this->_statisticsService;
    }

    /*
     * 删除评论
     * */
    public static function delComment($movieId,$userId){

        return self::findOne(['movie_id' => $movieId,'user_id' => $userId])->delete();
    }

    /*
     * 获取用户评分
     * */
    public static function getUserStar($movieId){

        $res =  self::findOne(['movie_id' => $movieId,'user_id' => (string)\Yii::$app->user->id,'type' => self::TYPE_USER]);

        return $res?$res->star:0;
    }

    public static function getCommentSelf($movieId){

        $res =  self::findOne(['movie_id' => $movieId,'user_id' => (string)\Yii::$app->user->id,'type' => self::TYPE_USER]);

        return $res?$res:null;
    }
}
