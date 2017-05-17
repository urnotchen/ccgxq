<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/16
 * Time: 14:17
 */

namespace frontend\modules\v1\models\forms;
use yii\base\Model;
use frontend\modules\v1\models\FilmProperty;


class FilmPropertyForm extends Model{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;

    public function rules(){

        return [
            ['property' , 'in' ,'range' => FilmProperty::$propertyList]
        ];

    }

}