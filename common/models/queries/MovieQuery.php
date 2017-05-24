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

    public function releaseTimestampSequence(){

        $this->orderBy(['release_timestamp' => SORT_DESC]);
        return $this;
    }
    public function orderUpdatedAt(){

        $this->orderBy(['updated_at' => SORT_DESC]);
        return $this;
    }

    public function propertyHotSequence(){

        $this->orderBy('film_property.sequence DESC,film_property.created_at DESC,movie.release_timestamp DESC');
        return $this;
    }
    public function propertyNewestSequence(){

        $this->orderBy('film_property.sequence DESC,film_property.created_at DESC,movie_index.create_at DESC,movie.release_timestamp DESC');
        return $this;
    }


}