<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/23
 * Time: 11:56
 */
namespace frontend\modules\v1\models\forms;


use frontend\modules\v1\models\FilmComment;
use frontend\traits\ModelPrepareTrait;

class CommentZanForm extends \yii\base\Model{

    use ModelPrepareTrait;

    public $id;

    public function rules()
    {
        return [
            [['id'],'required'],
            ['id' ,'exist', 'targetClass' => FilmComment::className(),'targetAttribute' => 'id'],
        ];
    }



}