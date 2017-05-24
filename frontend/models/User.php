<?php

namespace frontend\models;


class User extends \common\models\User implements \yii\web\IdentityInterface
{
    use \frontend\traits\UserIdentityTrait;

}

?>