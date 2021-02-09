<?php

namespace backend\modules\stat\models;

class UserToken extends \backend\models\UserToken
{
    /**
     * @return array
     */
    public static function getUserPlatformCount()
    {
        return [
            self::PLATFORM_QQ => self::find()->where([
                'platform' => self::PLATFORM_QQ
            ])->groupBy('user_id')->count(),
            self::PLATFORM_SINA => self::find()->where([
                'platform' => self::PLATFORM_SINA
            ])->groupBy('user_id')->count(),
            self::PLATFORM_WECHAT => self::find()->where([
                'platform' => self::PLATFORM_WECHAT
            ])->groupBy('user_id')->count(),
            self::PLATFORM_EMAIL => self::find()->where([
                'platform' => self::PLATFORM_EMAIL
            ])->groupBy('user_id')->count(),
        ];
    }
}

?>