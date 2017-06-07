<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/16
 * Time: 14:17
 */

namespace frontend\modules\v1\models\forms;
use frontend\modules\v1\models\Movie;
use yii\base\Model;
use frontend\modules\v1\models\FilmProperty;


class FilmCommentIndexForm extends Model{

    use \frontend\traits\ModelPrepareTrait;

    public $movie_id;

    public function rules(){

        return [
            [['movie_id'],'required'],
            ['movie_id' ,'exist', 'targetClass' => Movie::className(),'targetAttribute' => 'id'],
        ];

    }


}