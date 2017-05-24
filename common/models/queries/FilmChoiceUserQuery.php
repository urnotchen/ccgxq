<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/4
 * Time: 14:28
 */

namespace common\models\queries;

use common\models\FilmChoiceUser;

class FilmChoiceUserQuery extends \yii\db\ActiveQuery{

    public function find(){
        $this->where(['not',['status' => FilmChoiceUser::STATUS_TRASH]]);
    }
}