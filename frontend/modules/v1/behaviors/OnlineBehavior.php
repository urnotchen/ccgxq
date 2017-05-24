<?php

namespace frontend\modules\v1\behaviors;

class OnlineBehavior extends \yii\base\ActionFilter
{
    private $_accessToken;

    public function beforeAction($action)
    {
        //判断是否允许上线
        $userToken = \frontend\modules\v1\models\UserToken::findOneOrException([
            'access_token' => $this->getAccessToken()
        ]);
        \Yii::$app->deviceCache->operateLogin($userToken);

        return parent::beforeAction($action);
    }

    public function getAccessToken()
    {
        if ($this->_accessToken === null) {
            if (isset($_SERVER['HTTP_ACCESS_TOKEN'])) {
                $this->_accessToken = $_SERVER['HTTP_ACCESS_TOKEN'];
            } else {
                $this->_accessToken = '';
            }
        }

        return $this->_accessToken;
    }
}

?>