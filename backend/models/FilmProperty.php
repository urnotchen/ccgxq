<?php

namespace backend\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "film_property".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property integer $property
 * @property integer $sequence
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class FilmProperty extends \common\models\FilmProperty
{
    public static function getProperty($property,$movieId){

        return FilmProperty::findOne(['property' => $property,'status' => FilmProperty::STATUS_NORMAL,'movie_id' => $movieId]);
    }

    /*
     * 添加到列表
     * */
    public static function autoAddFilmProperty($movieId,$property){

        $record = self::getProperty($property,$movieId);
        if ($record) {
            $record->updated_at = time();
        } else {
            $movie = Movie::findOne($movieId);
            if(!$movie) {
                return ;
            }
            $record = new self;
            $record->movie_id = $movieId;
            $record->property = $property;
            $record->status = self::STATUS_NORMAL;
            $record->created_by = 0;
            $record->updated_by = 0;
        }
        $record->detachBehavior('blameable');
        $record->save();
        return $record;
    }
    /*
     * 从列表中取消
     * */
    public static function autoDelFilmProperty($movieId,$property){

        $record = self::getProperty($property,$movieId);
        if ($record) {
            $record->delete();
        }
        $record->detachBehavior('blameable');
    }

    /*
     * 获取某属性列表
     * */
    public static function getList($property){

        return self::find()->where(['property' => $property])->all();
    }
}
