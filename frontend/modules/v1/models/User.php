<?php

namespace frontend\modules\v1\models;


class User extends \frontend\models\User implements \yii\filters\RateLimitInterface
{
    use \common\traits\ModelPrepareTrait;
    use \common\traits\SaveExceptionTrait;

    use \frontend\modules\v1\traits\UserRateLimiterTrait;

    const
        OPERATE_PING = 1,
        OPERATE_LOGOUT = 2;

    public function fields()
    {
        return [
            'email',
//            'vip' => function(self $model) {
//                return $this->isSvip() ?
//                    self::USER_SVIP :
//                    ($this->isVip() ? self::USER_VIP : self::USER_NORMAL);
//            },
//            'expired_at' => function(self $model) {
//                return UserToken::findOne(['user_id' => $model->id,'device' => $model->device])?1:0;
//            }
        ];
    }

    public function extraFields()
    {
        return [
            'details'
        ];
    }

    public static function getEnumData()
    {
        $inherit = parent::getEnumData();
        $inherit = array_merge($inherit, [
            'operate' => [
                self::OPERATE_PING => 'ping',
                self::OPERATE_LOGOUT => '退出'
            ]
        ]);

        return $inherit;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasOne(UserDetails::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    /**
     * @param $device
     * @param $name
     * @param $type
     * @param int $expiration
     * @return UserToken
     */
    public function generateToken($device, $name, $type,$registrationID, $expiration = 0)
    {

        $timestamp = time();

        $expiration = $expiration > 0 ? $expiration : 60 * 60 * 24 * 30;

        $token = new UserToken;
        $token->scenario = UserToken::SCENARIO_LOGIN_EMAIL;
        $token->setAttributes([
            'user_id'   => $this->id,
            'expired_at' => $timestamp + $expiration,
            'device' => $device,
            'name' => $name,
            'type' => $type,
            'registration_id' => $registrationID
        ]);
        $token->save();

        return $token;
    }

    /**
     * @param $device
     * @param $name
     * @param $type
     * @param int $expiration
     * @return UserToken
     */
    public function updateToken($device, $name, $type,$registrationID, $expiration = 0)
    {

        $expiration = $expiration > 0 ? $expiration : 60 * 60 * 24 * 30;

        $token = UserToken::getInstance([
            'user_id'       => $this->id,
            'platform'      => UserToken::PLATFORM_EMAIL,
            'device'        => $device,
            'type'          => $type,
        ]);
        if ($token->isNewRecord){

            return $this->generateToken($device, $name, $type,$registrationID);
        }else{
            $token->scenario = UserToken::SCENARIO_LOGIN_EMAIL;

            $token->access_token = UserToken::generateAccessToken();
            $token->expired_at = time() + $expiration;
            $token->name = $name;
            $token->type = $type;
            $token->registration_id = $registrationID;
            $token->save();

            return $token;
        }
    }

    /**
     * @param $email
     * @return static
     * @throws \yii\web\HttpException
     */
    public static function findOneByEmailOrException($email)
    {
        $instance = static::findOne([
            'email' => $email,
        ]);

        if (empty($instance)) {

            throw new \yii\web\HttpException(
                400,
                'email not exists',
                \common\components\ResponseCode::USER_EMAIL_NOT_EXISTS
            );
        }

        return $instance;
    }

    /**
     * @param $vip
     * @param $expiration
     * @return bool
     */
//    public function becomeVip($vip, $expiration)
//    {
//        $time = time();
//
//        if ($vip == self::USER_SVIP) {
//            $this->scenario = self::SCENARIO_SVIP;
//
//            //续订累加
//            $this->svip_expired_at = $expiration + ($this->svip_expired_at>$time ? $this->svip_expired_at : $time);
//            //若存在剩余vip时间则向后顺延
//            $this->vip_expired_at += $this->vip_expired_at>$time ? $expiration : 0;
//
//        } elseif ($vip == self::USER_VIP) {
//            $this->scenario = self::SCENARIO_VIP;
//
//            //续订累加
//            $this->vip_expired_at = $expiration + ($this->vip_expired_at>$time ? $this->vip_expired_at : $time);
//        }
//
//        return true;
//    }

    public function getUserDetails(){
        return $this->hasOne(UserDetails::className(),['user_id' => 'id']);
    }
}

?>