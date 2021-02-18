<?php

namespace common\models;

/**
 * Class UserDetails
 * @package common\models
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $nickname
 * @property string $avatar
 * @property integer $gender
 * @property integer $birth
 * @property string $address
 * @property integer $career
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserDetails extends \yii\db\ActiveRecord
{
    use \common\traits\KVTrait;
    use \common\traits\EnumTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    const GENDER_MALE = 1, GENDER_FEMALE = 2, GENDER_SECRET = 3;

    const
        CAREER_STUDENT = 1,
        CAREER_DIRECTOR = 2,
        CAREER_STORYBOARD_ARTIST = 3,
        CAREER_CAMERAMAN = 4,
        CAREER_ARTIST = 5,
        CAREER_OTHER = 6,
        CAREER_SECRET = 7;

    const DEFAULT_AVATAR = 'default_avatar.jpg';

    public static function tableName()
    {
        return 'user_details';
    }

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'avatar' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'avatar',
                ],
                'value' => function ($event) {


                    return empty($event->sender->avatar) ?
                        \Yii::$app->request->hostInfo . '/files/images/default_avatar.jpg' :
                        $event->sender->avatar;
                },
            ]
        ];
    }

    public function rules()
    {
        return [
            ['user_id', 'required'],

            [['user_id', 'gender', 'career', 'birth'], 'integer'],
            [['nickname', 'address', 'avatar'], 'string', 'max' => 255],
            ['avatar', 'string', 'max' => 512],

            [['user_id'], 'unique'],

            ['user_id', 'exist', 'targetClass' => \common\models\User::className(), 'targetAttribute' => 'id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'   => 'ID',
            'nickname'   => '昵称',
            'avatar'     => '头像',
            'gender'      => '性别',
            'birth'      => '出生年',
            'address'  => '所在地',
            'career'    => '职业',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getEnumData()
    {
        return [
            'gender' => [
                self::GENDER_MALE => '男',
                self::GENDER_FEMALE => '女',
                self::GENDER_SECRET => '保密'
            ],
            'career' => [
                self::CAREER_STUDENT => '学生',
                self::CAREER_DIRECTOR => '导演',
                self::CAREER_STORYBOARD_ARTIST => '分镜师',
                self::CAREER_CAMERAMAN => '摄影',
                self::CAREER_ARTIST => '美工',
                self::CAREER_OTHER => '其他',
                self::CAREER_SECRET => '保密'
            ]
        ];
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
//        $avatar = 'http://' . \Yii::$app->params['qiniuDomain'] . '/' . $this->avatar;
//        return \Yii::$app->request->hostInfo . '/files/images/default_avatar.jpg';

        if(strpos($this->avatar,'http') !== 0 || strpos($this->avatar,'http') === false){
            $avatar = \Yii::$app->params['qiniuDomain'].$this->avatar;
        }else{
            $avatar = $this->avatar;
        }

        return $avatar;
    }
}





?>