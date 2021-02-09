<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "day_book".
 *
 * @property integer $id
 * @property string $order_id
 * @property string $day_time
 * @property string $book_time_arr
 * @property string $book_num_arr
 * @property string $pre_half_hour_people
 * @property integer $status
 * @property integer $booK_status_arr
 * @property string $created_at
 * @property string $updated_at
 */
class DayBook extends \yii\db\ActiveRecord
{

    use EnumTrait;
    use KVTrait;
    const STATUS_NORMAL = 1,STATUS_OVER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'day_book';
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
            [['day_time','order_id'],'unique','targetAttribute' => ['day_time', 'order_id']],
            [['day_time', 'book_time_arr', 'book_num_arr', 'book_status_arr', 'pre_half_hour_people'], 'required'],
            [['day_time', 'order_id', 'book_total','book_num','pre_half_hour_people', 'status', 'created_at', 'updated_at'], 'integer'],

            [['book_num_arr', 'book_status_arr', 'book_time_arr'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'day_time' => 'Day Time',
            'book_time_arr' => 'Book Time Arr',
            'book_num_arr' => 'Book Num Arr',
            'pre_half_hour_people' => 'Pre Half Hour People',
            'status' => 'Status',
            'book_status_arr' => '',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
    public static function getEnumData()
    {
        return [
            'status' => [
                self::STATUS_NORMAL => '正常',

            ],

        ];
    }

    public static function addOneRecord($arr){

        $model = new self;
        $model->order_id = $arr['order_id'];
        $model->day_time = $arr['day_time'];
        $model->book_time_arr = $arr['book_time_arr'];
        $model->book_num_arr = $arr['book_num_arr'];
        $model->book_status_arr = $arr['book_status_arr'];
        $model->pre_half_hour_people = $arr['pre_half_hour_people'];
        $model->book_total = $arr['book_total'];
        $model->book_total = $arr['book_total'];
        $model->book_num = $arr['book_num'];
        if($model->save())
            return true;
        return false;
    }
}
