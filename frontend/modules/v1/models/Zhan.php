<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/12
 * Time: 14:46
 */
namespace frontend\modules\v1\models;


class Zhan extends \frontend\modules\v1\models\Movie{

    public function fields()
    {
        $fields =  parent::fields(); // TODO: Change the autogenerated stub

        $fields = array_merge($fields,[
            'commentNum' => function($model){
                return FilmComment::getCommentNum($model->id);
            },
           ],[
            'commentFive' => function($model){
                return FilmComment::getCommentFive($model->id);
            }]);

        return $fields;
    }

    public function extraFields()
    {
        return parent::extraFields(); // TODO: Change the autogenerated stub
    }

    /*
     * 随机获取n个月的m部新片
     * 只做电影斩推荐用,时间不用太严格,默认每个月30天
     * */
    public static function getNewestMovies($userId,$alreadyMovieIds,$monthNum,$movieNum){

        return self::find()
            ->where(['between','release_timestamp',time() - 86400 * 30 * $monthNum,time()])
            ->andWhere(['not',['id' => $alreadyMovieIds]])
            //加入想看的电影 不再展现
            ->andWhere(['not',['id' => FilmChoiceUser::getMovieIds(FilmChoiceUser::TYPE_WANT,$userId)]])
            ->andWhere(['not',['id' => FilmChoiceUser::getMovieIds(FilmChoiceUser::TYPE_SAW,$userId)]])
            ->choiceMovie()->limit($movieNum)->orderBy('rand()')->all();
    }

    /*
     * 获取其他类型的高分电影
     * 只做电影斩推荐用,时间不用太严格,默认每个月30天
     * */
    public static function getHighMovies($userId,$alreadyMovieIds,$types,$movieNum){


        return self::find()
            ->join('join',FilmTypeConn::tableName(),Movie::tableName().'.id = '.FilmTypeConn::tableName().'.movie_id')
            ->where(['type_id' => $types])
            ->andWhere(['not',[Movie::tableName().'.id' => $alreadyMovieIds]])
            //加入想看的电影 不再展现
            ->andWhere(['not',[Movie::tableName().'.id' => FilmChoiceUser::getMovieIds(FilmChoiceUser::TYPE_WANT,$userId)]])
            ->andWhere(['not',[Movie::tableName().'.id' => FilmChoiceUser::getMovieIds(FilmChoiceUser::TYPE_SAW,$userId)]])
            ->groupBy('movie.id')
            ->choiceMovie()->limit($movieNum)->orderBy(['score' => SORT_DESC])->all();
    }
    /*
     * 获取评价超过7分的电影 评价人数从多到少排序
     * 只做电影斩推荐用,时间不用太严格,默认每个月30天
     * */
    public static function getCommonMovies($userId,$alreadyMovieIds,$movieNum){


        return self::find()
            ->where(['>=','score',7])
            ->andWhere(['not',[Movie::tableName().'.id' => $alreadyMovieIds]])
            //加入想看的电影 不再展现
            ->andWhere(['not',[Movie::tableName().'.id' => FilmChoiceUser::getMovieIds(FilmChoiceUser::TYPE_WANT,$userId)]])
            ->andWhere(['not',[Movie::tableName().'.id' => FilmChoiceUser::getMovieIds(FilmChoiceUser::TYPE_SAW,$userId)]])
            ->choiceMovie()->limit($movieNum)->orderBy(['comment_num' => SORT_DESC])->all();
    }
}