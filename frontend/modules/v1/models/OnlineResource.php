<?php

namespace frontend\modules\v1\models;

class OnlineResource extends \frontend\models\OnlineResource
{
    public function fields()
    {
        return [
            'url',
            'definition'
        ];
    }
}

?>