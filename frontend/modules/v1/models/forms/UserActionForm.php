<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/23
 * Time: 11:56
 */
namespace frontend\modules\v1\models\forms;


use frontend\modules\v1\models\FilmChoiceUser;
use frontend\modules\v1\models\Movie;
use frontend\traits\ModelPrepareTrait;

class UserActionForm extends \yii\base\Model{

    use ModelPrepareTrait;

    public $movie_id,$action,$type;

    public function rules()
    {
        return [
            [['movie_id','action','type'],'required'],
            [['movie_id'] ,'exist', 'targetClass' => Movie::className(),'targetAttribute' => 'id'],
            [['type'],'in','range' => FilmChoiceUser::TYPE_LIST],
            [['action'],'in','range' => FilmChoiceUser::ACTION_LIST],
        ];
    }

//    public function prepare($rawParams, $runValidation = true)
//    {/*{{{*/
//        $this->load( $rawParams , '');
//
//        if ($runValidation) $this->validate();
//
//        return $this;
//    }/*}}}*/
}