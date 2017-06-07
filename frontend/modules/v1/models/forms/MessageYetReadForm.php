<?php

namespace frontend\modules\v1\models\forms;


use frontend\traits\ModelPrepareTrait;

class MessageYetReadForm extends \yii\base\Model
{


    use ModelPrepareTrait;

    public $id;

    public function rules()
    {
        return [
            [['id'], 'required'],

        ];
    }




}
