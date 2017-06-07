<?php
namespace frontend\modules\v1\behaviors;


use frontend\modules\v1\models\FilmChoiceUser;
use frontend\modules\v1\models\FilmComment;
use frontend\modules\v1\models\FilmRecommendUser;
use yii\base\Behavior;

class AddRecommendUserBehavior extends Behavior{

    public $comment;

    public function events()
    {
        return [FilmComment::EVENT_AFTER_INSERT => 'addRecommendUser'];
    }

    public function addRecommendUser($event){

        if($this->comment){
            //添加到推荐表
            FilmRecommendUser::record($this->comment);
            //添加到个人选择表
//            FilmChoiceUser::userAction($this->comment->movie_id,FilmChoiceUser::TYPE_SAW,self::Ac)
        }
    }

}