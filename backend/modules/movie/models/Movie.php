<?php

namespace backend\modules\movie\models;

class Movie extends \backend\models\Movie
{

    /*
     * 为电影斩筛选数据
     * */
    public static function getMovieZhanIds($typeList,$rank){

        $arr = [];
        //先筛选排名前n的类型,每个类型国产的10部,外国5部,如果不足,不补
        for($i = 0 ; $i < $rank; $i ++){
            $temp = self::find()->select(self::tableName().'.id')->joinWith('type')->where([FilmTypeConn::tableName().'.type_id' => $typeList[$i]['type_id']])->andwhere(['>=','score',7])->andWhere(['>','comment_num',50000])->andFilterWhere(['like','producer_country','中国'])->choiceMovie()->commentNumSequence()->limit(10)->column();
            $temp2 = self::find()->select(self::tableName().'.id')->joinWith('type')->where([FilmTypeConn::tableName().'.type_id' => $typeList[$i]['type_id']])->andwhere(['>','score',8])->andWhere(['>','comment_num',50000])->andFilterWhere(['not like','producer_country','中国'])->choiceMovie()->commentNumSequence()->limit(5)->column();
            foreach(array_merge($temp ,$temp2) as $eachMovieId){
                if(!in_array($eachMovieId,$arr)) {
                    array_push($arr,$eachMovieId);
                }
            }
        }
        //筛选剩下的类型,混到一起筛选,国产75部,外国25部
        for(;$i < count($typeList) - 1 ;$i++){
            $typeListOther[] = $typeList[$i]['type_id'] ;
        }

        $temp3 = self::find()->select(self::tableName().'.id')->joinWith('type')->where([FilmTypeConn::tableName().'.type_id' => $typeListOther])->andwhere(['>=','score',7])->andWhere(['>','comment_num',50000])->andFilterWhere(['like','producer_country','中国'])->choiceMovie()->commentNumSequence()->limit(75)->column();
        $temp4 = self::find()->select(self::tableName().'.id')->joinWith('type')->where([FilmTypeConn::tableName().'.type_id' => $typeListOther])->andwhere(['>=','score',8])->andWhere(['>','comment_num',50000])->andFilterWhere(['not like','producer_country','中国'])->choiceMovie()->commentNumSequence()->limit(25)->column();

        foreach(array_merge($temp3,$temp4)as $eachMovieId){
            if(!in_array($eachMovieId,$arr)) {
                array_push($arr,$eachMovieId);
            }
        }

        return $arr;
    }



}

?>