<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/18
 * Time: 15:44
 */

namespace frontend\modules\v1\models\forms;


use frontend\modules\v1\models\Movie;
use yii\base\Model;

class MovieDetailsForm extends Model{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;

    public $id;

    public function rules(){

        return [
            [['id'],'required'],
            [['id'],'integer'],
            ['id' ,'exist', 'targetClass' => Movie::className(),'targetAttribute' => 'id'],

        ];
    }

    public function prepare($rawParams,$runValidation = true){

        $this->load($rawParams, '');

        if ($runValidation) $this->validate();

        return Movie::findOneOrException(['id' => $this->id]);

    }
}