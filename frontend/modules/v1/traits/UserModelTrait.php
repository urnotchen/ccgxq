<?php

namespace frontend\modules\v1\traits;

use frontend\models\User;

/**
 * UserModelTrait class file.
 * @Author haoliang
 * @Date 13.01.2016 15:45
 */
trait UserModelTrait
{

    private $_user;

    public function init()
    {
        parent::init();
        if (empty($this->_user)) {
            throw new \yii\base\InvalidConfigException("self::user must be set.");
        }
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function setUser(User $value)
    {
        $this->_user = $value;
    }

}
