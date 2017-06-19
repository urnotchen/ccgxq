<?php

namespace backend\models;

use Yii;

class FilmSynopsis extends \common\models\FilmSynopsis
{
    public function rules()
    {
        return array_merge(parent::rules(),
            [['search_text'],'string']
        );
    }
}
