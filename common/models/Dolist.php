<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dolist".
 *
 * @property integer $id
 * @property string $content
 * @property string $sequence
 * @property string $end_at
 * @property integer $status
 * @property string $complete_remarks
 * @property string $complete_at
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Dolist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dolist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'status'], 'required'],
            [['content'], 'string'],
            [['sequence', 'end_at', 'status', 'complete_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['complete_remarks'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'sequence' => 'Sequence',
            'end_at' => 'End At',
            'status' => 'Status',
            'complete_remarks' => 'Complete Remarks',
            'complete_at' => 'Complete At',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
