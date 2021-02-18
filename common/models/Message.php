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
    const STATUS_NORMAL = 1,STATUS_DELETE=2;

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

            'status' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'status',
                ],
                'value' => function ($event) {

                    return self::STATUS_NORMAL;
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
            'created_at' => '咨询人',
            'created_by' => '咨询时间',
            'updated_at' => '回复人',
            'updated_by' => '回复时间',
        ];
    }

}
