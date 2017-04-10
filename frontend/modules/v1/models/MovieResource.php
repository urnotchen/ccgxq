<?php

namespace frontend\modules\v1\models;

class MovieResource extends \frontend\models\MovieResource
{
    public function fields()
    {
        return [
            'bilibili',
            'vqq',
            'iqiyi',
            'youku',
            'souhu',
            'acfun'
        ];
    }
}

?>