<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/4
 * Time: 14:28
 */

namespace common\models\queries;

class MovieQuery extends \yii\db\ActiveQuery{

    public function orderSequence(){

        $this->orderBy(['sequence' => SORT_DESC]);
        return $this;
    }

    public function orderReleaseTime(){

        $this->orderBy(['release_timestamp' => SORT_DESC]);
        return $this;
    }
    public function orderUpdatedAt(){

        $this->orderBy(['updated_at' => SORT_DESC]);
        return $this;
    }
}