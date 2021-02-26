<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\FindOrExceptionTrait;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "deal".
 *
 * @property integer $id
 * @property integer $approval_id
 * @property string $file
 * @property string $reply
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Deal extends \yii\db\ActiveRecord
{
    use FindOrExceptionTrait;
    use EnumTrait;
    use KVTrait;
    const STATUS_NORMAL = 1,STATUS_PASS = 2,STATUS_REJECT = 3;
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

                    return self::STATUS_NORMAL;
                },
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'file_arr',], 'required'],
            [['approval_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['file_arr', 'reply','label_arr'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'approval_id' => '审批项目',
            'file_arr' => '文件',
            'reply' => '回复',
            'status' => '状态',
            'created_at' => '上传时间',
            'created_by' => '上传人',
            'updated_at' => '受理时间',
            'updated_by' => '受理人',
        ];
    }

    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_NORMAL => '未处理',
                self::STATUS_PASS => '已通过',
                self::STATUS_REJECT => '未通过',
            ],

        ];
    }
    public function getApproval()
    {/*{{{*/
        return $this->hasOne(Approval::className(), ['id' => 'approval_id']);
    }/*}}}*/
}
