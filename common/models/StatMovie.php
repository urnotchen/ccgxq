<?php

namespace common\models;

use common\traits\EnumTrait;
use Yii;

/**
 * This is the model class for table "stat_movie".
 *
 * @property integer $id
 * @property integer $day
 * @property integer $movie_id
 * @property integer $num
 * @property integer $type
 */
class StatMovie extends \yii\db\ActiveRecord
{

    use EnumTrait;

    const TYPE_WANT = 1 , TYPE_SUBSCRIBE = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_movie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'movie_id', 'num', 'type'], 'required'],
            [['day', 'movie_id', 'num', 'type'], 'integer'],
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
            'movie_id' => '电影',
            'num' => '数量',
            'type' => '类型',
        ];
    }

    public function getMovie(){

        return $this->hasOne(Movie::className(),['id' => 'movie_id']);
    }

    public static function getEnumData(){

        return [
            'type' => [
                self::TYPE_SUBSCRIBE => '订阅',
                self::TYPE_WANT => '想看'
            ]
        ];
    }
}
