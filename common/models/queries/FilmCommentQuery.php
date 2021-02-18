<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/4
 * Time: 14:28
 */

namespace common\models\queries;


use common\models\FilmComment;
use yii\db\Expression;

class FilmCommentQuery extends \yii\db\ActiveQuery{

    public function typeSequence(){

        $typeList = implode(',',FilmComment::TYPE_RANGE);
        $userId = \Yii::$app->getUser()->id;
        $this->orderBy(new Expression("user_id = {$userId} desc, FIELD(type,{$typeList})"));

        return $this;

    }
    public function goodNumSequence(){

            $this->addOrderBy(['good_num' => SORT_DESC]);

            return $this;

        }

    public function from($tables){
        if (!is_array($tables)) {
            $tables = preg_split('/\s*,\s*order/', trim($tables), -1, PREG_SPLIT_NO_EMPTY);
        }
        $this->from = $tables;
        return $this;
    }



}