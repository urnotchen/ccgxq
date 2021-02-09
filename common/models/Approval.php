<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "approval".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @property integer $sequence
 * @property string $agency
 * @property string $basic_sxlx
 * @property string $basic_bjlx
 * @property string $basic_sszt
 * @property string $basic_xscj
 * @property string $basic_cnbjsx
 * @property string $basic_fdbjsx
 * @property integer $basic_is_charge
 * @property string $basic_dbsxccs
 * @property string $basic_zxfs
 * @property string $basic_jdtsfs
 * @property string $basic_blsj
 * @property string $basic_bldd
 * @property string $process
 * @property string $blclml
 * @property string $sltj
 * @property string $sfbz
 * @property string $sdyj
 * @property string $question
 * @property integer $is_online
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Approval extends \yii\db\ActiveRecord
{
    use EnumTrait;
    use KVTrait;
    const STATUS_NORMAL = 1,STATUS_DELETE=2;
    const ONLINE_YES = 1,ONLINE_NO = 2;


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
        return 'approval';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'name', 'sequence', 'agency', 'basic_sxlx', 'basic_bjlx', 'basic_sszt', 'basic_xscj', 'basic_cnbjsx', 'basic_fdbjsx', 'basic_is_charge', 'basic_dbsxccs', 'basic_zxfs', 'basic_jdtsfs', 'basic_blsj', 'basic_bldd', 'process', 'sltj', 'sfbz', 'sdyj', 'question', 'is_online',], 'required'],
            [['project_id', 'sequence', 'basic_is_charge', 'is_online', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['blclml', 'sltj', 'sdyj', 'question'], 'string'],
            [['name', 'agency', 'basic_sxlx', 'basic_bjlx', 'basic_sszt', 'basic_xscj', 'basic_cnbjsx', 'basic_fdbjsx', 'basic_dbsxccs', 'basic_zxfs', 'basic_jdtsfs', 'basic_blsj', 'basic_bldd', 'process', 'sfbz'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => '项目',
            'name' => '业务名称',
            'sequence' => '业务序号',
            'agency' => '	办理机构',
            'basic_sxlx' => '事项类型',
            'basic_bjlx' => '办件类型',
            'basic_sszt' => '实施主体',
            'basic_xscj' => '行使层级',
            'basic_cnbjsx' => '承诺办结时限',
            'basic_fdbjsx' => '法定办结时限',
            'basic_is_charge' => '是否收费',
            'basic_dbsxccs' => '到办事现场次数',
            'basic_zxfs' => '咨询方式',
            'basic_jdtsfs' => '监督投诉方式',
            'basic_blsj' => '办理时间',
            'basic_bldd' => '办理地点',
            'process' => '办理流程',
            'blclml' => '办理材料目录',
            'sltj' => '受理条件',
            'sfbz' => '收费标准',
            'sdyj' => '设定依据',
            'question' => '常见问题',
            'is_online' => '是否在线办理',
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
            'is_online' => [
                self::ONLINE_YES => '是',
                self::ONLINE_NO => '否',
            ],
        ];
    }
}
