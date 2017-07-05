<?php

namespace common\models;


/**
 * Class FeedBack
 * @package common\models
 *
 * @property integer $id
 * @property integer $type
 * @property string $index
 * @property integer $status
 * @property string $app_v
 * @property string $device
 * @property string $os
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property Reply $userFeedback
 * @property array(Reply) $replies
 */
class Feedback extends \yii\db\ActiveRecord
{
    use \common\traits\EnumTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    const
        TYPE_APP = 1,
        TYPE_PROJECT = 2,
        TYPE_SCENE = 3,
        TYPE_CUT = 4;

    const
        STATUS_UNREAD = 1,
        STATUS_READ = 2,
        STATUS_REPLY = 3;

    const SEPARATOR_INDEX = '.';

    public static function tableName()
    {
        return 'feedback';
    }

    public function behaviors()
    {
        return [
            'createdAt' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
                'value' => function ($event) {
                    return time();
                },
            ],
            'createdBy' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                ],
                'value' => function ($event) {
                    $user = \Yii::$app->get('user', false);

                    return $user && !$user->isGuest ? $user->id : null;
                },
            ],
            'status' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'status',
                ],
                'value' => function ($event) {

                    return 1;
                },
            ],
        ];
    }

    public function rules()
    {
        return [
            [['app_v', 'device', 'os'], 'string'],
            [['status', 'created_at', 'created_by'], 'integer'],
            [['app_v', 'device', 'os'], 'required'],
        ];
    }

    public static function getEnumData()
    {
        return [
            'type' => [
                self::TYPE_APP => '应用',
                self::TYPE_PROJECT => '项目',
                self::TYPE_SCENE => '场',
                self::TYPE_CUT => '镜'
            ],
            'status' => [
                self::STATUS_UNREAD => '未读',
                self::STATUS_READ => '已读',
                self::STATUS_REPLY => '已回复',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'status'         => '状态',
            'app_v'          => '应用版本',
            'device'         => '设备',
            'os'             => '系统',
            'created_at'     => 'Created AT',
            'created_by'     => 'Created By'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFeedback()
    {
        return $this->hasOne(Reply::className(), ['fb_id' => 'id'])
            ->orderBy(Reply::tableName() . '.created_at')
            ->groupBy(Reply::tableName() . '.id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['fb_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function setUserReplyRead()
    {
        Reply::updateAll(
            ['status' => Reply::STATUS_READ],
            ['fb_id' => $this->id, 'is_sender' => Reply::BOOL_TRUE]
        );

        $this->status = $this->status == self::STATUS_UNREAD ? self::STATUS_READ : $this->status;

        return true;
    }
}

?>