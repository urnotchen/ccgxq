<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "repair".
 *
 * @property integer $id
 * @property string $department_id
 * @property string $repaired_by
 * @property string $repaired_content
 * @property string $repaired_reply
 * @property integer $replied_by
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Repair extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repair';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'replied_by', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['repaired_content', 'status'], 'required'],
            [['repaired_content', 'repaired_reply'], 'string'],
            [['repaired_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department_id' => 'Department ID',
            'repaired_by' => 'Repaired By',
            'repaired_content' => 'Repaired Content',
            'repaired_reply' => 'Repaired Reply',
            'replied_by' => 'Replied By',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
