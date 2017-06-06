<?php

namespace frontend\modules\v1\models;

use frontend\models\FilmProperty;
use yii\db\Exception;

class FilmRecommendUser extends \frontend\models\FilmRecommendUser
{


    /*
     * 把评论过的电影加入到个人推荐表中,方便推荐,状态status为未推荐状态,type为
     * */
    public static function record (FilmComment $comment)
    {/*{{{*/
        //查找推荐表中有没有这条数据,没有就说明不是来自电影斩
        $filmRecommendUser = self::findOne(['movie_id' => $comment->movie_id,'user_id' => $comment->user_id]);

        if($filmRecommendUser) {

            $filmRecommendUser->star = $comment->star;

            $filmRecommendUser->choice = self::CHOICE_SAW;

        }else{
            $filmRecommendUser = new static;
            $filmRecommendUser->user_id = $comment->user_id;
            $filmRecommendUser->star = $comment->star;
            $filmRecommendUser->movie_id = $comment->movie_id;
            $filmRecommendUser->type = self::TYPE_USER;
            $filmRecommendUser->source = $comment->source;
        }

        $filmRecommendUser->save();

        return $filmRecommendUser;
    }/*}}}*/

    /*
     * 把生成的推荐电影,加入到数据库中
     * 如果用户中途退出,可以接续给用户推荐剩余的部分
     * @params array
     * */
    public static function addToRecommendRecord($movieIds,$userId,$type){

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($movieIds as $eachMovieId) {

                if(self::findOne(['movie_id' => $eachMovieId,'user_id' => $userId])) continue;

                $filmRecommendUser = new static;
                $filmRecommendUser->movie_id = $eachMovieId;
                $filmRecommendUser->user_id = $userId;
                $filmRecommendUser->star = null;
                $filmRecommendUser->type = $type;
                $filmRecommendUser->status = self::STATUS_WAIT_RECOMMEND;
                $filmRecommendUser->choice = self::CHOICE_DEFAULT;
                $filmRecommendUser->source = self::SOURCE_ZHAN;
                $filmRecommendUser->save();
            }
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollBack();
            throw new $e;
        }
    }

    /*
     * 电影斩跳过操作
     * */
    public static function moviePass($userId,$movieId){

        $filmRecommendUser = self::findOne(['user_id' => $userId,'movie_id' => $movieId]);

        $filmRecommendUser->choice = self::CHOICE_PASS;

        $filmRecommendUser->save();

        return $filmRecommendUser;
    }

    /*
     * 状态变为已推荐
     *
     * */
    public static function  toRecommended($userId,$movieId)
    {

        $filmRecommendUser = self::findOneOrException(['user_id' => $userId,'movie_id' => $movieId]);
        $filmRecommendUser->status = self::STATUS_YET_RECOMMEND;
        $filmRecommendUser->save();

    }

}
