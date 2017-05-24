<?php
namespace frontend\modules\v1\behaviors;


use frontend\modules\v1\models\FilmChoiceUser;
use frontend\modules\v1\models\FilmComment;
use yii\base\Behavior;

class AddUserChoiceBehavior extends Behavior{

    public $comment;

    public function events()
    {
        return [FilmComment::EVENT_AFTER_INSERT => 'addUserChoice'];
    }

    public function addUserChoice($event){

        if($this->comment){

            FilmChoiceUser::userAction($this->comment->movie_id,FilmChoiceUser::TYPE_SAW,FilmChoiceUser::ACTION_ADD,$this->comment->user_id);
        }
    }

}