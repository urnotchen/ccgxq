<?php

namespace backend\models;

use Yii;

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
    public static function getProperty($property,$movie_id){

        return FilmProperty::findOne(['property' => $property,'status' => FilmProperty::STATUS_NORMAL,'movie_id' => $movie_id]);
    }
}
