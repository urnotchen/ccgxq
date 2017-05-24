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

        $this->orderBy(new Expression("FIELD(type,{$typeList})"));

        return $this;

    }
    public function goodNumSequence(){

            $this->orderBy(['good_num' => SORT_DESC]);

            return $this;

        }




}