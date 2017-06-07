<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/16
 * Time: 14:17
 */

namespace frontend\modules\v1\models\forms;
use frontend\modules\v1\models\FilmRecommendUser;
use frontend\modules\v1\models\Movie;
use yii\base\Model;
use frontend\modules\v1\models\FilmProperty;


class FilmCommentForm extends Model{

    use \frontend\traits\ModelPrepareTrait;

    public $content,$star,$movie_id,$user_id,$source;


    public function rules(){

        return [
            [['content'],'string'],
            [['star'],'integer'],
            [['star'],'in','range' => range(0,5)],
            [['source'],'in','range' => [FilmRecommendUser::SOURCE_ZHAN,FilmRecommendUser::SOURCE_OTHER]],
            ['movie_id' ,'exist', 'targetClass' => Movie::className(),'targetAttribute' => 'id'],
        ];

    }

    public function prepare($rawParams,$runValidation = true){

        $this->load($rawParams, '');

        if ($runValidation) $this->validate();

        return $this;

    }

}