<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "consultation".
 *
 * @property integer $id
 * @property string $patient_name
 * @property integer $age
 * @property integer $sex
 * @property string $disease_name
 * @property string $illness
 * @property integer $need_consultation
 * @property integer $consultation_at
 * @property string $consultation_people
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Consultation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consultation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patient_name', 'age', 'sex', 'disease_name', 'illness', 'status'], 'required'],
            [['age', 'sex', 'need_consultation', 'consultation_at', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['illness'], 'string'],
            [['patient_name', 'disease_name', 'consultation_people'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patient_name' => 'Patient Name',
            'age' => 'Age',
            'sex' => 'Sex',
            'disease_name' => 'Disease Name',
            'illness' => 'Illness',
            'need_consultation' => 'Need Consultation',
            'consultation_at' => 'Consultation At',
            'consultation_people' => 'Consultation People',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
