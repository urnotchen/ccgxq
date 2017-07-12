<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/23
 * Time: 11:56
 */
namespace frontend\modules\v1\models\forms;


use frontend\modules\v1\models\Movie;
use frontend\traits\ModelPrepareTrait;

class ZhanRevocationForm extends \yii\base\Model{

    use ModelPrepareTrait;

    public $movie_id,$type;

    public function rules()
    {
        return [
            [['movie_id','type'],'required'],
            [['movie_id'] ,'exist', 'targetClass' => Movie::className(),'targetAttribute' => 'id'],
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