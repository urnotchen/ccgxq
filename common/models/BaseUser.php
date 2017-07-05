<?php
namespace common\models;


/**
 * Class BaseUser
 * @package common\models
 *
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $avatar
 * @property string $real_name
 * @property bool $status
 * @property string $mark
 * @property integer $created_at
 * @property integer $updated_at
 */
class BaseUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    use \common\traits\KVTrait;

    const STATUS_INACTIVE = 0, STATUS_ACTIVE = 1;

//    public static function getDb()
//    {
//        return \Yii::$app->dbUser;
//    }

    public static function tableName()
    {
        return '{{user}}';
    }

    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_ACTIVE   => '启用',
                self::STATUS_INACTIVE => '禁用',
            ],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::fineOne(['access_token' => $token]);
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public static function getBaseInfo($id)
    {

        $baseUser = self::findOne([
            'id' => $id,
        ]);

        if(! empty($baseUser)) {
            return (object)[
                'id' => $baseUser->id,
                'username' => $baseUser->username,
                'real_name' => 'haha',
                'avatar' => 'no',
                'email' => 'email'
            ];
        } else {
            return (object)[
                'id' => '',
                'name' => '',
                'real_name' => '',
                'avatar' => '',
                'email' => ''
            ];
        }
    }

}
