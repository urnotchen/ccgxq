<?php
namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use common\models\queries\UserQuery;

class FrontUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    use \common\traits\EnumTrait;
    use \common\traits\KVTrait;

    const STATUS_ACTIVE = 1, STATUS_INACTIVE = 2;

    const CERTIFICATES_SFZ = 1,CERTIFICATES_jGZ = 2 ,CERTIFICATES_HZ = 3,CERTIFICATES_TW = 4,CERTIFICATES_GA = 5;



    const SCENARIO_PASSWORD = 'password';

    public function behaviors()
    {/*{{{*/
        return [
            'timestamp' => TimestampBehavior::className(),
            'blameable' => BlameableBehavior::className(),

            'authKey' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key',
                ],
                'value' => function ($event) {
                    return \Yii::$app->getSecurity()->generateRandomString();
                }
            ],
        ];
    }/*}}}*/

    public function rules()
    {/*{{{*/
        return [
            [['certificates_num'], 'unique'],
            [['username',], 'unique'],

            [['username', 'password','certificates_type','certificates_num','real_name','telephone'], 'required','skipOnEmpty' => false],

            [['status'], 'integer'],
            [['username', 'password','real_name'], 'string', 'max' => 255],
            [['certificates_type','certificates_type','certificates_num','telephone'], 'string', 'max' => 255],


            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['password', 'hashPassword'],

        ];
    }/*}}}*/

    public function hashPassword($attr, $options)
    {/*{{{*/
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->$attr);
    }/*}}}*/

//    public function scenarios()
//    {/*{{{*/
//        return [
//            # 普通修改
//            'default' => [
//                'role_id', 'username', 'email', 'avatar', 'real_name', 'qq',
//                'alipay', 'mark', 'status','department'
//            ],
//            # 创建用户
//            'create' => [
//                'username', 'password','certificates_type','certificates_num','real_name','telephone',
//            ],
//            # 重置密码
//            'resetPassword' => ['password'],
//            # 请求重置密码
//            'requestResetPassword' => ['email'],
//            self::SCENARIO_PASSWORD => ['password'],
//        ];
//    }/*}}}*/

    public function attributeLabels()
    {/*{{{*/
        return [

            'id'                   => 'ID',
            'username'             => '用户名',
            'real_name'            => '真实名',

            'telephone'            => '手机号',
            'certificates_type'            => '证件类型',
            'certificates_num'            => '证件号码',

            'password'             => '密码',
            'sure_password'             => '确认密码',
            'status'               => '状态',
            'auth_key'             => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',

            'created_at'           => '创建时间',
            'created_by'           => '创建者',
            'updated_at'           => '修改时间',
            'updated_by'           => '修改者',

        ];
    }/*}}}*/

    public static function getEnumData()
    {/*{{{*/
        return [
            'status' => [
                self::STATUS_ACTIVE   => '启用',
                self::STATUS_INACTIVE => '禁用',
            ],
            'certificates_type' => [
                self::CERTIFICATES_SFZ   => '身份证',
                self::CERTIFICATES_jGZ => '军官证',
                self::CERTIFICATES_HZ => '护照',
                self::CERTIFICATES_TW => '台湾通行证',
                self::CERTIFICATES_GA => '港澳通行证',
            ],
        ];
    }/*}}}*/

    public static function tableName()
    {/*{{{*/
        return 'front_user';
    }/*}}}*/

    public static function find()
    {/*{{{*/
        return new UserQuery(get_called_class());
    }/*}}}*/

    public static function findIdentity($id)
    {/*{{{*/
        return static::findOne($id);
    }/*}}}*/

    public static function findIdentityByAccessToken($token, $type = null)
    {/*{{{*/
        return static::fineOne(['access_token' => $token]);
    }/*}}}*/

    public static function findByUsername($username)
    {/*{{{*/
        return static::findOne(['username' => $username]);
    }/*}}}*/

    public static function findByPasswordResetToken($token)
    {/*{{{*/
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }/*}}}*/

    public static function isPasswordResetTokenValid($token)
    {/*{{{*/
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }/*}}}*/

    public function validateAuthKey($authKey)
    {/*{{{*/
        return $this->getAuthKey() === $authKey;
    }/*}}}*/

    public function validatePassword($rawPassword)
    {/*{{{*/
        return Yii::$app->getSecurity()->validatePassword($rawPassword, $this->password);
    }/*}}}*/

    public function getId()
    {/*{{{*/
        return $this->id;
    }/*}}}*/

    public function getAuthKey()
    {/*{{{*/
        return $this->auth_key;
    }/*}}}*/

    public function generatePasswordResetToken()
    {/*{{{*/
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }/*}}}*/

    public function removePasswordResetToken()
    {/*{{{*/
        $this->password_reset_token = null;
    }/*}}}*/

    public function getUpdatedBy()
    {/*{{{*/
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }/*}}}*/

    public function getCreatedBy()
    {/*{{{*/
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }/*}}}*/

    public static function getUserTotal() {

        return static::find()->count();
    }


    /**
     * @param $id
     * @return object
     */
    public static function getBaseInfo($id)
    {

        $baseUser = self::findOne([
            'id' => $id,
        ]);

        if(! empty($baseUser)) {
            return (object)[
                'id' => $baseUser->id,
                'username' => $baseUser->username,
                'real_name' => $baseUser->real_name,
                'avatar' => $baseUser->avatar,
                'email' => $baseUser->email
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
    public static  function getUserKv(){
        return self::kv('id','real_name');
    }
}
