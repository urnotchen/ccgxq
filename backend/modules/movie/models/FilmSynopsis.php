<?php

namespace backend\modules\movie\models;

use common\models\UserDetails;
use Yii;

/**
 * This is the model class for table "film_synopsis".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property string $text
 * @property integer $source
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class FilmSynopsis extends \backend\models\FilmSynopsis
{



    /*
     * 获取简介的作者
     * */
    public static function getSynopsisAuthor(self $model){

        switch($model->source){
            case self::SOURCE_DOUBAN:
                return '官方';
            case self::SOURCE_MTIME:
                return '官方';
            case self::SOURCE_USER:
                $user =  UserDetails::findOne($model->created_by);
                if($user){
                    return $user->nickname;
                }
                return '';
            default :
                return '';
        }
    }
}
