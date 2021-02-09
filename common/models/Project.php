<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property integer $project_category_id
 * @property string $name
 * @property string $sxlx
 * @property string $kbbm
 * @property string $sszt
 * @property string $xscj
 * @property string $sdyj
 * @property string $qlly
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Project extends \yii\db\ActiveRecord
{
    use EnumTrait;
    use KVTrait;
    const STATUS_NORMAL = 1,STATUS_DELETE=2;


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
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_category_id', 'name', 'sxlx', 'kbbm', 'sszt', 'xscj', 'sdyj', 'qlly'], 'required'],
            [['project_category_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['sdyj'], 'string'],
            [['name', 'sxlx', 'kbbm', 'sszt', 'xscj', 'qlly'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_category_id' => '项目分类',
            'name' => '名称',
            'sxlx' => '事项类型',
            'kbbm' => '基本编码',
            'sszt' => '实施主体',
            'xscj' => '行使层级',
            'sdyj' => '设定依据',
            'qlly' => '权力来源',
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

        ];
    }

    public function getCategory(){

        return $this->hasOne(ProjectCategory::className(),['id'=>'project_category_id']);
    }

    public static function getProjectKv(){

        return self::k_v('id','name',['where' => ['status' => self::STATUS_NORMAL]]);
    }
}
