<?php

namespace common\models;
use common\models\queries\MovieQuery;


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
        ];
    }

    public function rules()
    {
//        return [
//            [['name_cn', 'name_en', 'poster', 'director', 'grade_db', 'actor'], 'required'],
//            [['name_cn', 'name_en', 'poster', 'grade_db', 'imdb'], 'string', 'max' => 255],
//            ['douban', 'integer'],
//            [['director', 'actor'], 'string'],
//            [['director', 'actor'], 'filter', 'filter' => function($value) {
//                $value = str_replace('，', ',', $value);
//
//                return \yii\helpers\Json::encode(explode(',', $value));
//            }],
//            ['show_time', 'validateTime']
//        ];
        return [
            [['id'], 'required'],
            [['id', 'pic_id', 'release_year', 'comment_num', 'episodes', 'single_running_time','release_timestamp'], 'integer'],
            [['score', 'one_star', 'two_star', 'three_star', 'four_star', 'five_star'], 'number'],
            [['synopsis'], 'string'],
            [['movie_url', 'director', 'type', 'producer_country', 'language', 'release_date', 'imdb', 'imdb_title', 'official_website', 'premiere', 'running_time'], 'string', 'max' => 255],
            [['title', 'screen_writer', 'alias'], 'string', 'max' => 500],
            [['actor'], 'string', 'max' => 1000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '豆瓣id',
            'movie_url' => '豆瓣链接',
            'pic_id' => 'Pic ID',
            'title' => '片名',
            'director' => '导演',
            'screen_writer' => '编剧',
            'actor' => '演员',
            'type' => '类型',
            'producer_country' => '制片国家',
            'language' => '语言',
            'release_date' => '上映日期',
            'alias' => '别名',
            'imdb' => 'Imdb链接',
            'imdb_title' => 'Imdb',
            'official_website' => '官方网站',
            'premiere' => '首播',
            'release_year' => '年份',
            'running_time' => '片场',
            'comment_num' => '评价人数',
            'score' => '评分',
            'one_star' => '一星',
            'two_star' => '二星',
            'three_star' => '三星',
            'four_star' => '四星',
            'five_star' => '五星',
            'episodes' => '集数',
            'single_running_time' => '单集时长',
            'synopsis' => '简介',
        ];
    }
    public static function find(){

        return new MovieQuery(get_called_class());
    }

    public function getImage(){
        return $this->hasOne(Image::className(),['id' => 'pic_id']);
    }

    public static function getProperty($property,$movie_id){
        return FilmProperty::findOne(['property' => $property,'status' => FilmProperty::STATUS_NORMAL,'movie_id' => $movie_id]);
    }

    public function getOnlineResource(){

        return $this->hasOne(MovieIndex::className(),['douban' => 'id']);
    }
    public function getOnlineResource2(){
        return $this->hasOne(MovieIndex::className(),['imdb' => 'imdb_title']);
    }



}

?>