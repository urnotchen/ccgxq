<?php

namespace backend\components;

use Yii;

class User extends \yii\web\User
{

    public function loginRequired($checkAjax = true, $checkAcceptHeader = true)
    {

        $this->loginUrl .= '?return_url=' . Yii::$app->getRequest()->getAbsoluteUrl();

        return parent::loginRequired($checkAjax, $checkAcceptHeader);
    }

    /**
     * 验证账号是否被禁用
     *
     * @return bool
     */
    public function checkStatus()
    {
        $baseUser = \common\models\BaseUser::findOne(['id' => $this->id]);

        if (isset($baseUser->status) && ($baseUser->status == $baseUser::STATUS_ACTIVE)) {

            return true;
        }

        return false;
    }

}