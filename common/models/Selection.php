<?php

namespace common\models;

use common\traits\EnumTrait;
use Yii;

/**
 * This is the model class for table "selection".
 *
 * @property integer $id
 * @property integer $department_id
 * @property integer $grade
 * @property string $advise
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Selection extends \yii\db\ActiveRecord
{

    use EnumTrait;
    const GRADE_5 = 5,GRADE_4 = 4,GRADE_3 = 3,GRADE_2 = 2,GRADE_1 = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'selection';
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

        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id'], 'required'],
            [['department_id', 'grade', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['advise'], 'string', 'max' => 1000],
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
            'grade' => '评分',
            'advise' => '建议',
            'created_at' => '',
            'created_by' => '',
            'updated_at' => '',
            'updated_by' => '',
        ];
    }

    public static function getEnumData(){

        return [
            'grade' => [
                self::GRADE_5 => '满意',
                self::GRADE_4 => '基本满意',
                self::GRADE_3 => '一般',
                self::GRADE_2 => '不满意',
            ],
        ];
    }
}
