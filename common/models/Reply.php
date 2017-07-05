<?php

namespace common\models;

/**
 * Class Reply
 * @package common\models
 *
 * @property integer $id
 * @property integer $fb_id
 * @property integer $user_id
 * @property integer $is_sender
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 */
class Reply extends \yii\db\ActiveRecord
{
    use \common\traits\EnumTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    const BOOL_TRUE = 1,
        BOOL_FALSE = 0;

    const OFFICIAL_NAME = '看啥电影';

    const STATUS_UNREAD = 1,
        STATUS_READ = 2;

    public static function tableName()
    {
        return 'feedback_reply';
    }

    public function behaviors()
    {
        return [
            'createAt' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
                'value' => function ($event) {
                    return time();
                },
            ],
            'createBy' => [
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

                    return self::STATUS_UNREAD;
                },
            ],
        ];
    }

    public function rules()
    {
        return [
            ['content', 'string'],
            [['fb_id', 'user_id', 'is_sender', 'status', 'created_at', 'created_by'], 'integer'],
            [['fb_id', 'user_id', 'content'], 'required'],
            ['fb_id', 'exist',  'targetClass' => \common\models\Feedback::className(), 'targetAttribute' => 'id']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'fb_id'      => 'FB ID',
            'user_id'    => 'USER ID',
            'is_sender'  => '发送方',
            'content'    => '内容',
            'created_at' => 'Created AT',
            'created_by' => 'Created By',
        ];
    }

    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_UNREAD => '未读',
                self::STATUS_READ => '已读',
            ],
        ];
    }
}

?>