<?php

namespace common\models;
use common\traits\KVTrait;

/**
 * Class User
 * @package common\models
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property bool $status
 * @property integer $last_use_time
 * @property integer $vip_expired_at
 * @property integer $svip_expired_at
 * @property integer $allowance
 * @property integer $allowance_updated_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property UserDetails details
 */
class User extends \yii\db\ActiveRecord
{
    use \common\traits\EnumTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;
    use KVTrait;

    const STATUS_INACTIVE = 0, STATUS_ACTIVE = 1;

    const
        SCENARIO_PASSWORD = 'password',
        SCENARIO_NONE = 'none',
        SCENARIO_THIRD_PARTY = 'third_party',
        SCENARIO_VIP = 'vip',
        SCENARIO_SVIP = 'svip';

    const USER_NORMAL = 0, USER_VIP = 1, USER_SVIP = 2;

    public static function tableName()
    {
        return 'frontend_user';
    }

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'password' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'password',
                ],
                'value' => function ($event) {
                    $password = $event->sender->password;
                    if (empty($password)) {

                        return null;
                    }

                    return \Yii::$app->security->generatePasswordHash($password);
                },
            ],
            'lastUseTime' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'last_use_time',
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'last_use_time',
                ],
                'value' => function ($event) {

                    return time();
                },
            ],
            'resetPassword' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'password',
                ],
                'value' => function ($event) {
                    $model = $event->sender;

                    if ($model->scenario == self::SCENARIO_PASSWORD
                        && !empty($model->getOldAttributes('password'))
                    ) {
                        return \Yii::$app->security->generatePasswordHash($model->password);
                    }

                    return $model->password;
                },
            ],
            'status' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'status',
                ],
                'value' => function ($event) {

                    return self::STATUS_ACTIVE;
                },
            ],
        ];
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'on' => self::SCENARIO_DEFAULT],

            ['password', 'required', 'on' => self::SCENARIO_PASSWORD],

            ['email', 'string', 'max' => 255],
            ['password', 'string', 'max' => 255],

            ['email', 'email'],

            ['email', 'unique', 'targetClass' => self::className()],
            [['last_use_time', 'allowance', 'allowance_updated_at'], 'integer'],
//            [['last_use_time', 'allowance', 'allowance_updated_at', 'vip_expired_at', 'svip_expired_at'], 'integer'],
//
//            ['vip_expired_at', 'required', 'on' => self::SCENARIO_VIP],
//            ['svip_expired_at', 'required', 'on' => self::SCENARIO_SVIP]
        ];
    }

    public function scenarios()
    {/*{{{*/
        return [
            self::SCENARIO_DEFAULT => ['email', 'password'],
            self::SCENARIO_PASSWORD => ['password'],
            self::SCENARIO_THIRD_PARTY => ['email'],
            self::SCENARIO_NONE => [],
            self::SCENARIO_VIP => ['vip_expired_at'],
            self::SCENARIO_SVIP => ['svip_expired_at', 'vip_expired_at']
        ];
    }

    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_INACTIVE => '禁用',
                self::STATUS_ACTIVE => '启用',
            ],
            'vip' => [
                self::USER_NORMAL => '免费用户',
                self::USER_VIP => '标准用户',
                self::USER_SVIP => '高级用户'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'status' => 'Status',
            'last_use_time' => '最后使用时间',
            'vip_expired_at' => '会员',
            'svip_expired_at' => '过期时间',
            'created_at' => '注册时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @param $id
     * @return int
     */
    public static function updateLastUseTime($id)
    {

        $model = self::findOne($id);

        $model->last_use_time = time();

        return $model->save();

//        return self::updateAll(['id' => $id], ['last_use_time' => time()]);
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {

        return \Yii::$app->getSecurity()->validatePassword(
            $password,
            $this->password
        );
    }

    /**
     * @param $password
     * @return bool|int
     */
    public function changePassword($password)
    {
        $this->scenario = self::SCENARIO_PASSWORD;
        $this->password = $password;

        if ($this->save()) {

            //过期用户所有密码登录token
            return UserToken::updateAll(['expired_at' => time() - 1], [
                'user_id' => $this->id,
                'platform' => UserToken::PLATFORM_EMAIL
            ]);
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isSvip()
    {
        return $this->svip_expired_at > time();
    }

    /**
     * @return bool
     */
    public function isVip()
    {
        return $this->svip_expired_at < time() && $this->vip_expired_at > time();
    }

    /**
     * @return bool
     */
    public function isNormalUser()
    {
        return $this->svip_expired_at < time() && $this->vip_expired_at < time();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasOne(UserDetails::className(), ['user_id' => 'id']);
    }

    /**
     * @return int|string
     */
    public static function getUserTotal()
    {

        return static::find()->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    /**
     * @return false|int
     */
    public function delete()
    {
        Feedback::deleteAll(['created_by' => $this->id]);
        Reply::deleteAll(['user_id' => $this->id]);

        $projects = Project::find()->joinWith('metadata')->where([
            'created_by' => $this->id,
            Metadata::tableName() . '.belong' => Metadata::BELONG_EXTERNAL
        ])->all();

        foreach ($projects as $project) {
            $project->delete();
        }

        Purchase::deleteAll(['user_id' => $this->id]);

        Share::deleteAll(['user_id' => $this->id]);

        StaffUser::deleteAll(['user_id' => $this->id]);

        UserDetails::deleteAll(['user_id' => $this->id]);
        UserToken::deleteAll(['user_id' => $this->id]);

        return parent::delete();
    }

    /*
     * 获取user_id和registrationId (为推送使用)
     * */
    public static function getUserIds()
    {
        return UserToken::kv('user_id', 'registration_id', function ($query) {
            $query->where(['id' => self::find()->select('id')->column()])->andWhere(['>', 'expired_at', time()])->andWhere(['not', ['registration_id' => null]]);
        });

    }

    /*
     * 获取最大的用户id(为统计 redis 使用)
     * */
    public static function getMaxUserId(){

        return self::find()->max('id');
    }

}
?>