<?php

namespace common\models;

use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "partment".
 *
 * @property integer $id
 * @property string $partname
 * @property string $info
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Partment extends \yii\db\ActiveRecord
{
    use \common\traits\EnumTrait;
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;
    use KVTrait;

    const STATUS_NORMAL = 1,STATUS_UNNORMAL=0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partment';
    }

    /**
     * @inheritdoc
     */
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
    public function rules()
    {
        return [
            [['partname'], 'required'],
            [['partname', 'info'], 'string'],
            [[ 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partname' => '部门名称',
            'info' => '科室说明',
            'status' => '状态',
            'created_at' => '创建时间',
            'created_by' => '创建人',
            'updated_at' => '修改时间',
            'updated_by' => '修改人',
        ];
    }

    public static function getPartmentKv(){

        return self::k_v('id','partname',['where' => ['status' => self::STATUS_NORMAL]]);
    }
}
