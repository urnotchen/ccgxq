<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $position_id
 * @property string $name
 * @property string $img
 * @property string $content
 * @property string $map
 * @property integer $times
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Order extends \yii\db\ActiveRecord
{
    use EnumTrait;
    use KVTrait;
    const STATUS_NORMAL = 1,STATUS_STOP = 2 , STATUS_OVER = 3 , STATUS_DELETE = 4;
    const POSITION_YL = 1,POSITION_EL = 2;
    const WORK_TIME1 = 1,WORK_TIME2 = 2, WORK_TIME3 = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
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
    public function rules()
    {
        return [
            [['position_id', 'name',  'content',  'pre_hour_people','phone','address'], 'required'],
            [['position_id', 'times','interval', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['content','morning_time','afternoon_time','tips','img'], 'string'],
//            ['img','file', 'extensions' => 'png, jpg'],
            ['work_time' ,'validateWorkTime'],
            [['name', 'img', 'map','work_time'], 'string', 'max' => 255],
            ['pre_hour_people','match','pattern'=>'/^\d*[02468]$/','message' => '人数必须是偶数'],

        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->img->saveAs('upload/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function validateWorkTime($attr)
    {

        switch ($this->work_time){
           case self::WORK_TIME1:
               $this->morning_time = '08:30-11:30';
               $this->afternoon_time = '13:30-16:30';
               break;
           case self::WORK_TIME2:
               $this->morning_time = '08:30-11:30';
               $this->afternoon_time = '14:00-16:30';
               break;
           case self::WORK_TIME3:
               $this->morning_time = '08:30-11:30';
               $this->afternoon_time = '14:00-17:00\'';
               break;
           default:
               var_dump($this->morning_time);
               var_dump($this->afternoon_time);
               $this->addError('时间不合法');
               break;
       }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position_id' => '办事窗口位置',
            'name' => '名称',
            'img' => '图片',
            'content' => '内容',
            'map' => '地址',
            'times' => '预约次数',
            'pre_hour_people' => '每小时预约人数',
            'phone' => '联系电话',
            'address' => '地址信息',
            'work_time' => '营业时间',
            'tips' => '注意事项',
            'status' => '状态',
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
                self::STATUS_STOP => '暂停预约',
                self::STATUS_OVER => '人满',
                self::STATUS_DELETE => '已删除',
            ],
            'position' => [
                self::POSITION_YL => '一楼大厅',
                self::POSITION_EL => '二楼大厅',
            ],
            'work_time' => [
                self::WORK_TIME1 => '周一至周五上午8:30——11:30,下午13:30——16:30',
                self::WORK_TIME2 => '周一至周五上午8:30——11:30,下午14:00——16:30',
                self::WORK_TIME3 => '周一至周五上午8:30——11:30,下午14:00——17:00',
            ],
        ];
    }
    //todo key=>val表封装

}
