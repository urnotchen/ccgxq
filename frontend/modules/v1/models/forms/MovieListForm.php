<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/16
 * Time: 12:19
 */

namespace frontend\modules\v1\models\forms;

use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\Movie;
use yii\base\Model;


class MovieListForm extends Model{

    use \frontend\traits\ModelPrepareTrait;

    public $type,$count,$max,$since;

    public function rules(){

        return [
            [['type'] , 'required'],
            [['type','count'], 'integer',],
            [['type'], 'in','range' => FilmProperty::$propertyList],
            ['max' ,'exist', 'targetClass' => Movie::className(),'targetAttribute' => 'id'],
            ['since' ,'exist', 'targetClass' => Movie::className(),'targetAttribute' => 'id'],

        ];
    }

}