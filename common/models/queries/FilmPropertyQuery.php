<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/4
 * Time: 14:28
 */

namespace common\models\queries;

class FilmPropertyQuery extends \yii\db\ActiveQuery{

    public function find(){
        $this->where(['not',['status' => \common\models\FilmProperty::STATUS_TRASH]]);
    }

    public function sequenceNotNUll(){

        $this->where(['not',['sequence' => null]]);
    }

}