<?php
namespace frontend\modules\v1\behaviors;


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

        if($this->comment->movie_id)
        if($this->comment){
//            AuthorMessage::addPaymentMessage($this->payslip);
            FilmRecommendUser::record($this->comment);
        }
    }

}