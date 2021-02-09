<?php

namespace common\models;

use common\traits\EnumTrait;
use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $day_time
 * @property string $book_begin_time
 * @property string $book_end_time
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Book extends \yii\db\ActiveRecord
{
    use EnumTrait;
    use KVTrait;
    const STATUS_NORMAL = 1,STATUS_CANCEL = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
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
//            'createdBy' => [
//                'class' => \yii\behaviors\AttributeBehavior::className(),
//                'attributes' => [
//                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
//                ],
//                'value' => function ($event) {
//                    $user = \Yii::$app->get('user', false);
//
//                    return $user && !$user->isGuest ? $user->id : null;
//                },
//            ],
            'status' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'status',
                ],
                'value' => function ($event) {
                    $model = $event->sender;
                    $model->status =  self::STATUS_NORMAL;
                    $model->book_begin_time = $model->book_time_arr_val * 1800 + 7  * 3600 + strtotime('today');
                    $model->book_end_time = $model->book_begin_time + 1800;
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
            [['order_id', 'day_book_id','day_time', 'book_time_arr_val'], 'required'],
            [['order_id', 'day_time','book_time_arr_val','book_begin_time', 'book_end_time','book_time_arr_val', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['day_time'],'safe'],
//            [['day_book_id','created_by'],'unique','targetAttribute' => ['day_book_id', 'created_by'],'skipOnEmpty' => false,'message' => '您已预约过当日项目，不可重复预约'],

            ['book_time_arr_val','validateBookTime']
            ];
    }
    /*
     * 检验这个时间段预约满没满
     *
     * */
    public function validateBookTime($attr){
        $day_book = \frontend\models\DayBook::findOne($this->day_book_id);
        $book_num_arr = json_decode($day_book->book_num_arr);
        if($book_num_arr[$this->book_time_arr_val] >= $day_book->pre_half_hour_people){
            $this->addError($attr,'本时段预约人数已满，请选择其他时段');
        }

        $user = \Yii::$app->get('user', false);

        $this->created_by =  $user && !$user->isGuest ? $user->id : null;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '预定项目',
            'day_time' => '日期',
            'book_begin_time' => '开始时间',
            'book_end_time' => '结束时间',
            'day_book_id' => '结束时间',
            'book_time_arr_val' => '预约时间',
            'status' => '状态',
            'created_at' => '预约时间',
            'created_by' => '预约人',
            'updated_at' => '修改时间',
            'updated_by' => '修改人',
        ];
    }

    public function getOrder()
    {/*{{{*/
        return $this->hasOne(\frontend\models\Order::className(), ['id' => 'order_id']);
    }/*}}}*/
}
