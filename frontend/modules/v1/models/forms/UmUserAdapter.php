<?php

namespace frontend\modules\v1\models\forms;

use yii\helpers\ArrayHelper;

use frontend\modules\v1\models\UserToken;

/**
 * UmUserAdapter class file.
 *
 * 友盟用户access_token信息适配(usersocial,userdetail)器
 *
 */
class UmUserAdapter extends \yii\base\Model
{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;

    public $accessToken, $expiration, $iconURL, $platform, $name, $uid, $gender, $device, $deviceName, $type,$registrationID;

    private $_userAttributes;

    public function rules()
    {
        return [
            [['accessToken', 'expiration', 'iconURL', 'platform', 'name', 'uid', 'device', 'deviceName','registrationID'], 'required'],
            [['accessToken', 'expiration', 'iconURL', 'name', 'uid', 'device', 'deviceName','registrationID'], 'string'],
            [['gender', 'platform', 'type'], 'integer'],
            ['type', 'default', 'value' => UserToken::TYPE_PHONE],
        ];
    }

    public function parse($params)
    {
        $this->load($params, '');
        $this->validate();

        $this->_userAttributes = [
            'platform'         => $this->validateThirdParty($this->platform),
            'open_id'          => $this->uid,
            'expired_at'       => strtotime($this->expiration),
            'access_token'     => $this->accessToken,
            'nickname'         => $this->name,
            'avatar'           => $this->iconURL,
            'gender'           => $this->gender,
            'device'           => $this->device,
            'name'             => $this->deviceName,
            'type'             => $this->type,
            'registration_id'  => $this->registrationID
        ];

        return $this;
    }

    public function getUserAttr($attr, $default = null)
    {
        return ArrayHelper::getValue($this->_userAttributes, $attr, $default);
    }

    public function getUserAllAttr()
    {
        return $this->_userAttributes;
    }

    protected function validateThirdParty($thirdParty)
    {
        $platforms = [
            UserToken::PLATFORM_SINA,
            UserToken::PLATFORM_QQ,
            UserToken::PLATFORM_WECHAT,
        ];

        if (! in_array($thirdParty, $platforms)) {
            throw new \yii\web\HttpException(
                400, 'unsupported third party',
                \common\components\ResponseCode::SOCIAL_LOGIN_UNSUPPORTED_THIRD_PARTY
            );
        }

        return $thirdParty;
    }

}
