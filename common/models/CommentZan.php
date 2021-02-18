<?php

namespace common\models;

use common\traits\FindOrExceptionTrait;
use common\traits\SaveExceptionTrait;
use Yii;

/**
 * This is the model class for table "comment_zan".
 *
 * @property integer $id
 * @property string $comment_id
 * @property string $user_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class CommentZan extends \yii\db\ActiveRecord
{
    use SaveExceptionTrait;
    use FindOrExceptionTrait;


    const ZAN_YES = 1,ZAN_CANCEL = 0;

    const ACTION_ZAN_YES  =1 ,ACTION_ZAN_CANCEL = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment_zan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'user_id', 'status'], 'required'],
            [['comment_id', 'user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['comment_id','user_id'],'unique','targetAttribute' => ['comment_id','user_id']],
        ];
    }
    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment_id' => 'Comment ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


}
