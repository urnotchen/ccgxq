<?php

namespace common\models;

use common\traits\EnumTrait;
use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $reply
 * @property string $telephone
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Message extends \yii\db\ActiveRecord
{

    use EnumTrait;
    const STATUS_NORMAL = 1,STATUS_REPLAY=2;
    const SCENARIO_REPLAY = 'none';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'telephone','name'], 'required'],
            [['content', 'reply'], 'string'],
            ['telephone', 'filter', 'filter' => 'trim'],
            ['telephone','match','pattern'=>'/^[1][34578][0-9]{9}$/'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
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

                    if(!Yii::$app->user->isGuest) {
                        return Yii::$app->user->id;
                    }
                    return null;
                },
            ],

            'updatedAt' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function ($event) {
                    return time();
                },
            ],
            'updatedBy' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
                'value' => function ($event) {

                    if(!Yii::$app->user->isGuest) {
                        return Yii::$app->user->id;
                    }
                    return null;
                },
            ],

            'status1' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'status',
                ],
                'value' => function ($event) {
                        return self::STATUS_NORMAL;
                },
            ],

            'status' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'status',
                ],
                'value' => function ($event) {
                    if($event->sender->reply) {
                        return self::STATUS_REPLAY;
                    }
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '咨询内容',
            'reply' => '回复',
            'telephone' => '电话号码',
            'name' => '姓名',
            'status' => '状态',
            'created_at' => '咨询时间',
            'created_by' => '咨询人',
            'updated_at' => '回复时间',
            'updated_by' => '回复人',
        ];
    }
    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_NORMAL => '未回复',
                self::STATUS_REPLAY => '已回复',
            ],
        ];
    }
}
