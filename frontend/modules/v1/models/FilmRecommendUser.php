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
            //如果这条评论评论的电影斩电影推荐的是已看过的电影 这个状态就要变更为已看过已推荐
            if($filmRecommendUser->choice == self::CHOICE_SAW_DEFAULT){
                $filmRecommendUser->choice = self::CHOICE_RECOMMEND_SAW;
            }else {
                $filmRecommendUser->choice = self::CHOICE_SAW;
            }
        }else{
            $filmRecommendUser = new static;
            $filmRecommendUser->user_id = $comment->user_id;
            $filmRecommendUser->star = $comment->star;
            $filmRecommendUser->movie_id = $comment->movie_id;
            $filmRecommendUser->type = self::TYPE_COMMENT;
        }
        $filmRecommendUser->source = $comment->source;

        $filmRecommendUser->save();

        return $filmRecommendUser;
    }/*}}}*/


    /*
     * 把电影斩推荐了的看过的电影 更新choice状态
     * */
    public static function updateZhanSaw (FilmComment $comment)
    {/*{{{*/
        //查找推荐表中有没有这条数据,没有就说明不是来自电影斩
        $filmRecommendUser = self::findOne(['movie_id' => $comment->movie_id,'user_id' => $comment->user_id]);

        if($filmRecommendUser) {

            $filmRecommendUser->star = $comment->star;
            //如果这条评论评论的电影斩电影推荐的是已看过的电影 这个状态就要变更为已看过已推荐
            if ($filmRecommendUser->choice == self::CHOICE_SAW_DEFAULT) {
                $filmRecommendUser->choice = self::CHOICE_RECOMMEND_SAW;
                $filmRecommendUser->save();
            }
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
    /*
     * 获取n部已经看过的电影,评分为3-5分
     * */
    public static function getSawMovie($userId,$movieNum){

        //找以前推荐了的但是没看的已看过的电影
        $res = self::find()->select('movie_id')->where(['choice' => self::CHOICE_SAW_DEFAULT])->limit($movieNum)->column();

        if(count($res) == $movieNum){
            return $res;
        }
        $resNew = self::find()
            ->where(['choice' => self::CHOICE_SAW,'user_id' => $userId])
            ->andWhere(['>=','star',3])
            ->andWhere(['not',['type' => self::TYPE_COMMENT]])
            ->limit($movieNum - count($res))->all();

        $arrIds = [];
        if($resNew){
            foreach($resNew as $eachRecommendUser){
                $arrIds[] = $eachRecommendUser->movie_id;
                //把状态改为看过的电影已推荐
                $eachRecommendUser->choice = self::CHOICE_SAW_DEFAULT;
                $eachRecommendUser->save();
            }
        }

        return array_merge($res,$arrIds);
    }

    /*
     * 判断用户是否需要推荐已看过的电影
     * */
    public static function needSawRecommend($user_id,$movieNum = 100){

        $sawNum = self::find()->where(['user_id' => $user_id,'choice' => self::CHOICE_SAW])->count();
        if($sawNum > $movieNum){
            return true;
        }
        return false;
    }
}
