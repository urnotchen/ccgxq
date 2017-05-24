<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/23
 * Time: 11:56
 */
namespace frontend\modules\v1\models\forms;


use frontend\modules\v1\models\FilmChoiceUser;
use frontend\traits\ModelPrepareTrait;

class UserChoiceListForm extends \yii\base\Model{

    use ModelPrepareTrait;

    public $type;

    public function rules()
    {
        return [
            [['type'],'required'],
            [['type'],'in','range' => FilmChoiceUser::TYPE_LIST],
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