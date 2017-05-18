<?php

namespace frontend\modules\v1\models;


class FilmSynopsis extends \frontend\models\FilmSynopsis
{

    public function fields()
    {
        return [
            'source',
            'content',
        ];
    }
}
