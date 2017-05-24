<?php

namespace common\services;

use Yii;
use common\models\User;
use yii\di\ServiceLocator;

/**
 * BizService class file.
 * @Author haoliang
 * @Date 10.11.2015 15:58
 * 
 * 此类被所有Service继承
 */
class BizService extends \yii\base\Component
{

    /**
     * @brief service locator 容器
     *
     * 由于locator 内容直接来自于程序, 故不再做多余的防御性编程
     *
     *  以下内容并未被使用
     */
    protected $_locator;

    public function init()
    {/*{{{*/
        $this->_locator = new ServiceLocator;
        parent::init();
    }/*}}}*/

    /**
     * @brief setLocator
     *
     * @param $config array
     *
     * @return static
     */
    public function setLocator(array $config)
    {/*{{{*/
        foreach ($config as $key => $val) {
            $this->_locator->set($key, $val);
        }

        return $this;
    }/*}}}*/

    public function getLocator($key, $default = false)
    {/*{{{*/
        if ($this->_locator->has($key))
            return $this->_locator->get($key);

        return $default;
    }/*}}}*/

    /**
     * @return null|\yii\web\IdentityInterface|\frontend\models\User
     */
    public function getUser()
    {
        $user =  Yii::$app->getUser()->identity;
        User::updateLastUseTime($user->id);
        return $user;
    }
}
