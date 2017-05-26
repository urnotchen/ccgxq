<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/4
 * Time: 14:28
 */

namespace common\models\queries;

class Query extends \yii\db\ActiveQuery{


    public function from($tables){
        if (!is_array($tables)) {
            $tables = preg_split('/\s*,\s*order/', trim($tables), -1, PREG_SPLIT_NO_EMPTY);
        }
         $this->from = $tables;
        return $this;
    }




}