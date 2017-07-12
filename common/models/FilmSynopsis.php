<?php

namespace common\models;

use common\traits\EnumTrait;
use frontend\models\UserDetails;
use Yii;
use frontend\models\User as FrontUser;

/**
 * This is the model class for table "film_synopsis".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property string $text
 * @property integer $source
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class FilmSynopsis extends \yii\db\ActiveRecord
{
    use EnumTrait;
    const SOURCE_DOUBAN = 1 ,SOURCE_MTIME = 2 , SOURCE_USER = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_synopsis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'source', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['content'], 'string'],
        ];
    }

    public static function getEnumData(){
        return [
            'source' => [
                self::SOURCE_DOUBAN => '豆瓣',
                self::SOURCE_MTIME => '时光网',
                self::SOURCE_USER => '个人',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => '电影名',
            'content' => '简介',
            'source' => '渠道',
            'created_at' => 'Created At',
            'created_by' => '用户昵称',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getMovie(){
        return $this->hasOne(Movie::className(),['id' => 'movie_id']);
    }
}
