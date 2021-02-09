<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $sendto
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Email extends \yii\db\ActiveRecord
{
    const STATUS_NORMAL = 1,STATUS_UNNORMAL=0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email';
    }
    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'blameable' => \yii\behaviors\BlameableBehavior::className(),

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
    public function rules()
    {
        return [
            [['title', 'content', 'sendto'], 'required','on' => 'default'],
            [['title', 'content',], 'required','on' => 'reply'],
            [['content'], 'string'],
            [['sendto', 'status','eid', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title','status'], 'string', 'max' => 255],

        ];
    }
    public function scenarios()
    {/*{{{*/
        return [

            #
            'default' => [
                'title', 'content', 'sendto'
            ],
            'reply' => [
                'title', 'content'
            ],
        ];
    }/*}}}*/
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'sendto' => '收件人',
            'status' => '状态',
            'eid' => '回复的邮件id',
            'created_at' => '发件时间',
            'created_by' => '发件人',
            'updated_at' => '修改时间',
            'updated_by' => '修改人',
        ];
    }
}
