<?php

namespace common\models;

/**
 * Class Movie
 * @package common\models
 *
 * @property integer $id
 * @property string $name_cn
 * @property string $name_en
 * @property string $poster
 * @property string $director
 * @property string $grade_db
 * @property string $actor
 * @property string $imdb
 * @property integer $show_time
 * @property integer $douban
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property MovieResource $movieResource
 * @property OnlineResource $onlineResource
 */
class Movie extends \yii\db\ActiveRecord
{
    use \common\traits\InstanceTrait;
    use \common\traits\FindOrExceptionTrait;

    public static function tableName()
    {
        return 'movie';
    }

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'blameable' => \yii\behaviors\BlameableBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['name_cn', 'name_en', 'poster', 'director', 'grade_db', 'actor'], 'required'],
            [['name_cn', 'name_en', 'poster', 'grade_db', 'imdb'], 'string', 'max' => 255],
            ['douban', 'integer'],
            [['director', 'actor'], 'string'],
            [['director', 'actor'], 'filter', 'filter' => function($value) {
                $value = str_replace('，', ',', $value);

                return \yii\helpers\Json::encode(explode(',', $value));
            }],
            ['show_time', 'validateTime']
        ];
    }

    public function validateTime($attr, $params)
    {
        if (empty($this->$attr)) {
            $this->$attr = 0;

            return true;
        }

        if (is_integer($this->$attr)) {

            return true;
        }

        $this->$attr = strtotime($this->$attr);
        return true;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_cn' => '中文名',
            'name_en' => '英文名',
            'douban' => '豆瓣',
            'imdb' => 'imdb',
            'poster' => '海报',
            'director' => '导演',
            'grade_db' => '豆瓣评分',
            'actor' => '演员',
            'show_time' => '上映时间',
            'created_at' => 'CREATED AT',
            'created_by' => 'CREATED BY',
            'updated_at' => 'UPDATED AT',
            'updated_by' => 'UPDATED BY'
        ];
    }

    public function delete()
    {
        MovieResource::deleteAll(['movie_id' => $this->id]);
        OnlineResource::deleteAll(['movie_id' => $this->id]);

        return parent::delete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieResource()
    {
        return $this->hasOne(MovieResource::className(), ['movie_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineResource()
    {
        return $this->hasOne(OnlineResource::className(), ['movie_id' => 'id']);
    }
}

?>