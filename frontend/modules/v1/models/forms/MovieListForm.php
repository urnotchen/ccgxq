<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/16
 * Time: 12:19
 */

namespace frontend\modules\v1\models\forms;
use yii\base\Model;


class MovieListForm extends Model{

    use \frontend\traits\ModelPrepareTrait;

    public $type;

    public function rules(){

        return [
            [['type'] , 'required'],
            [['type'], 'integer',],
            [['type'], 'in','range' => [1,2,3]],
        ];
    }

}