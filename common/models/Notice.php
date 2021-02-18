<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "notice".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Notice extends \yii\db\ActiveRecord
{
    use EnumTrait;
    use KVTrait;
    const STATUS_NORMAL = 1,STATUS_DELETE=2;
    const CATE_NOTICE = 1,CATE_POLICY = 2,CATE_JMZZ = 3,CATE_QYTJ = 4,CATE_BSZN = 5;
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
        return 'notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content','cate_id'], 'required'],
            [['content','from'], 'string'],
            [['status','cate_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'status' => '状态',
            'from' => '来源',
            'cate_id' => '分类',
            'created_at' => '创建时间',
            'created_by' => '创建人',
            'updated_at' => '修改时间',
            'updated_by' => '修改人',
        ];
    }
    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_NORMAL => '正常',
                self::STATUS_DELETE => '已删除',
            ],
            'cate_id' => [
                self::CATE_NOTICE => '公告通知',
                self::CATE_POLICY => '政策截图',
                self::CATE_JMZZ   => '精密制造',
                self::CATE_QYTJ   => '企业推介',
                self::CATE_BSZN   => '办事指南',
            ]
        ];
    }
}
