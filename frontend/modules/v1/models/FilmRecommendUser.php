<?php

namespace frontend\modules\v1\models;

use frontend\models\FilmProperty;

class FilmRecommendUser extends \frontend\models\FilmRecommendUser
{


    public static function record (FilmComment $comment)
    {/*{{{*/
        $filmRecommendUser = new static;
        if(in_array($comment->movie_id,FilmProperty::getRecommendOfficialIds())){
            $type = self::TYPE_OFFICIAL;
        }else{
            $type = self::TYPE_USER;
        }

        $filmRecommendUser->setAttributes([
            'user_id'         => $comment->user_id,
            'star'            => $comment->star,
            'movie_id'        => $comment->movie_id,
            'type'            => $type,
        ]);
        $filmRecommendUser->save();

        return $filmRecommendUser;
    }/*}}}*/



}
