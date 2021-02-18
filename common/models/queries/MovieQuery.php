<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/4
 * Time: 14:28
 */

namespace common\models\queries;

class MovieQuery extends \yii\db\ActiveQuery{

    public function choiceMovie(){

        $this->andwhere(['episodes' => null,'single_running_time' => null]);
        return $this;
    }

    public function orderSequence(){

        $this->orderBy(['sequence' => SORT_DESC]);
        return $this;
    }

    public function commentNumSequence(){

        $this->orderBy(['comment_num' => SORT_DESC]);
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

//        $this->orderBy(['movie_online_resource.created_at' => SORT_DESC]);
//        $this->groupBy('movie_online_resource.created_at');
        $this->orderBy(['movie.resource' => SORT_DESC,'film_property.sequence' => SORT_DESC,'film_property.created_at' => SORT_DESC,'movie.release_timestamp' => SORT_DESC]);
//        $this->groupBy('movie_online_resource.movie_id');
//        $this->orderBy('case  when movie_online_resource.created_at is not null then film_property.sequence desc, film_property.created_at desc, movie_online_resource.created_at desc, movie.release_timestamp desc
//                               else movie_online_resource.created_at desc ,film_property.sequence desc ,film_property.created_at desc ,movie.release_timestamp desc end');
        return $this;
    }

    public function beforeNowYear(){

        $this->andWhere(['<=','release_year',date("Y")]);

        return $this;
    }
    public static function propertyNewestSequenceSql(){

        return "`film_property.sequence desc,film_property.created_at desc,movie_online_resource.create_at desc ,movie.release_timestamp desc`";

    }

    public function from($tables){
        if (!is_array($tables)) {

            $tables = preg_split('/\s*,\s*or/', trim($tables), -1, PREG_SPLIT_NO_EMPTY);
        }
         $this->from = $tables;
        return $this;
    }

    //近3个月内 评分>=6 评价人数>=5000
    public function newestOrder(){

        $this->andWhere(['>=','score',6])->andWhere(['>=','comment_num',5000])->andWhere(['between','release_timestamp',time() - 3 * 30 * 86400,time()]);
        return $this;

    }




}