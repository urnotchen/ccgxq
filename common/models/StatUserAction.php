<?php

namespace common\models;

use backend\models\FilmChoiceUser;
use common\traits\EnumTrait;
use Yii;

/**
 * This is the model class for table "stat_user_action".
 *
 * @property integer $id
 * @property integer $day
 * @property integer $count
 * @property integer $type
 * @property integer $sub_type
 * @property string $daily
 */
class StatUserAction extends \yii\db\ActiveRecord
{
    use EnumTrait;

    const TYPE_COMMENT = 1 , TYPE_CHOICE_BY_ZHAN = 2;

    const SUB_TYPE_ZHAN_WANT = 1 , SUB_TYPE_ZHAN_SAW = 2 , SUB_TYPE_ZHAN_SUBSCRIBE = 3;

    const ZHAN_TYPE_LIST = [self::SUB_TYPE_ZHAN_WANT => FilmChoiceUser::TYPE_WANT,self::SUB_TYPE_ZHAN_SAW => FilmChoiceUser::TYPE_SAW,self::SUB_TYPE_ZHAN_SUBSCRIBE => FilmChoiceUser::TYPE_SUBSCRIBE];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_user_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'count', 'type'], 'required'],
            [['day', 'count', 'type', 'sub_type'], 'integer'],
            [['daily'], 'string'],
            [['day','type','sub_type'],'unique','targetAttribute' => ['day','type','sub_type']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => '日期',
            'count' => '数量',
            'type' => '类型',
            'sub_type' => '类型',
            'daily' => 'Daily',
        ];
    }

    /*
     * 添加记录
     * */
    public static function addRecord($day,$count,$daily,$type,$subType = null){

        $record = new self;

        $record->day = $day;
        $record->count = $count;
        $record->daily = $daily;
        $record->type = $type;
        $record->sub_type = $subType;

        $record->save();

    }

    public static function getEnumData(){

        return [
            'type' => [
                self::TYPE_CHOICE_BY_ZHAN => '电影斩标记',
                self::TYPE_COMMENT => '短评',
            ],
            'sub_type' => [
                self::SUB_TYPE_ZHAN_WANT => '想看',
                self::SUB_TYPE_ZHAN_SAW  => '看过',
                self::SUB_TYPE_ZHAN_SUBSCRIBE => '订阅',
            ]
        ];
    }
}
