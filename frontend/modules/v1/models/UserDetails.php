<?php

namespace frontend\modules\v1\models;


class UserDetails extends \frontend\models\UserDetails
{
    use \common\traits\ModelPrepareTrait;
    use \common\traits\SaveExceptionTrait;

    public function fields()
    {
        return [
            'nickname',
            'avatar',
            'gender',
            'birth',
            'address',
            'career'
        ];
    }
}

?>