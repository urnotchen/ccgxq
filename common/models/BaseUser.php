<?php
namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use common\models\queries\UserQuery;

class BaseUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    use \common\traits\EnumTrait;
    use \common\traits\KVTrait;

    const STATUS_ACTIVE = 1, STATUS_INACTIVE = 0;

    const PT_ACTIVE = 1, PT_INACTIVE = 0;

    const SCENARIO_PASSWORD = 'password';

    public function behaviors()
    {/*{{{*/
        return [
            'timestamp' => TimestampBehavior::className(),
            'blameable' => BlameableBehavior::className(),
            'avatar' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'avatar',
                ],
                'value' => function ($event) {
                    $model = $event->sender;
                    if (empty($model->avatar)) {
                        return 'http://static.bluelive.me/avatar/default.jpg';
                    }
                    return $model->avatar;
                },
            ],
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

            [['username', 'email','department'], 'required', 'on' => 'default'],
            [['username', 'email', 'password'], 'required', 'on' => 'create'],
            [['password'], 'required', 'on' => 'resetPassword'],
            [['email'], 'required', 'on' => 'requestResetPassword'],
            [['password'], 'required', 'on' => [self::SCENARIO_PASSWORD]],

            [['role_id', 'status','pt_active'], 'integer'],
            [['username', 'email', 'avatar', 'real_name', 'qq', 'alipay', 'mark', 'password', 'auth_key', 'password_reset_token','telephone'], 'string', 'max' => 255],

            ['email', 'email'],
            ['avatar', 'url'],
            [['username', 'email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['password', 'hashPassword'],

        ];
    }/*}}}*/

    public function hashPassword($attr, $options)
    {/*{{{*/
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->$attr);
    }/*}}}*/

    public function scenarios()
    {/*{{{*/
        return [
            # 普通修改
            'default' => [
                'role_id', 'username', 'email', 'avatar', 'real_name', 'qq',
                'alipay', 'mark', 'status','department'
            ],
            # 创建用户
            'create' => [
                'role_id', 'username', 'email', 'avatar', 'real_name', 'qq',
                'alipay', 'mark', 'status','department',
                'password',
            ],
            # 重置密码
            'resetPassword' => ['password'],
            # 请求重置密码
            'requestResetPassword' => ['email'],
            self::SCENARIO_PASSWORD => ['password'],
        ];
    }/*}}}*/

    public function attributeLabels()
    {/*{{{*/
        return [

            'id'                   => 'ID',
            'role_id'              => '角色',

            'username'             => '用户名',
            'email'                => '邮箱',
            'avatar'               => '头像',
            'real_name'            => '真实名',
            'qq'                   => 'qq',
            'alipay'               => '支付宝',
            'mark'                 => '标注',
            'telephone'            => '手机号',

            'department'           => '部门',

            'password'             => 'Password',
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
        ];
    }/*}}}*/

    public static function tableName()
    {/*{{{*/
        return 'user';
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
