<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/23
 * Time: 11:56
 */
namespace frontend\modules\v1\models\forms;


use frontend\traits\ModelPrepareTrait;

class UserStarSawListForm extends \yii\base\Model{

    use ModelPrepareTrait;

    public $star;

    public function rules()
    {
        return [
            [['star'],'required'],
            [['star'],'in','range' => range(1,5)],
        ];
    }

}