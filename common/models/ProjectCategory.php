<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "project_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class ProjectCategory extends \yii\db\ActiveRecord
{
    use EnumTrait;
    use KVTrait;
    const STATUS_NORMAL = 1,STATUS_DELETE=2;
    const CATEGORY_PERSONAL = 1, CATEGORY_COMPANY = 2;

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
    public static function tableName()
    {
        return 'project_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category_id',], 'required'],
            [['category_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'category_id' => '项目类别',
            'status' => '状态',
            'created_at' => '创建时间',
            'created_by' => '创建人',
            'updated_at' => '更新时间',
            'updated_by' => '更新人',
        ];
    }

    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_NORMAL => '正常',
                self::STATUS_DELETE => '已删除',
            ],
            'category' => [
                self::CATEGORY_PERSONAL => '个人办事',
                self::CATEGORY_COMPANY => '法人办事',
            ]

        ];
    }

    public static function getCategoryKv(){

        return [
            self::CATEGORY_PERSONAL => self::enum('category', self::CATEGORY_PERSONAL),
            self::CATEGORY_COMPANY => self::enum('category', self::CATEGORY_COMPANY),
            ];
    }

    public static function getProjectCategoryKv(){

        return self::k_v('id','name',['where'=>['status' => self::STATUS_NORMAL]]);
    }
}
