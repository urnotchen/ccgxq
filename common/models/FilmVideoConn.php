<?php

namespace common\models;
use common\traits\EnumTrait;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "film_video_conn".
 *
 * @property string $id
 * @property string $movie_id
 * @property integer $website_id
 * @property double $price
 * @property integer $type
 * @property string $url
 */
class FilmVideoConn extends \yii\db\ActiveRecord
{
    use EnumTrait;

    const PAY_TYPE_FREE = 1,PAY_TYPE_MONTH = 2,PAY_TYPE_SINGLE = 3,PAY_TYPE_UNDEFINED = 4,PAY_TYPE_ONLINE_MALL = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_video_conn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'website_id', 'type','created_at','created_by','updated_at','updated_by'], 'integer'],
            [['price'], 'number'],
            [['url'], 'string', 'max' => 1000],
        ];
    }

    public static function getEnumData()
    {/*{{{*/
        return [
            'status' => [
//                self:: PAY_TYPE_FREE => '免费',
//                self::PAY_TYPE_MONTH   => '/月',
            ]
        ];
    }/*}}}*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => 'Movie ID',
            'website_id' => 'Website ID',
            'price' => 'Price',
            'type' => 'Type',
            'url' => 'Url',
        ];
    }

    public static function getVideoLink($movieId){

        $res = self::find()->where(['movie_id' => $movieId])->all();
        $arr = [];
        $i = 0;
        $str = '';
        foreach($res as $videoLink){
            $arr[$i]['websiteName'] = Html::a($videoLink->website->name . $videoLink->website->sub_name,$videoLink->url,['target' => '_blank']);
            switch($videoLink->type){
                case self::PAY_TYPE_FREE:
                    $arr[$i]['price'] = '免费';
                    break;
                case self::PAY_TYPE_MONTH:
                    $arr[$i]['price'] = $videoLink->price .'元/月';
                    break;
                case self::PAY_TYPE_SINGLE:
                    $arr[$i]['price'] = $videoLink->price.'元/部';
                    break;
                case self::PAY_TYPE_UNDEFINED:
                    $arr[$i]['price'] = '';
                    break;
                case self::PAY_TYPE_ONLINE_MALL:
                    $arr[$i]['price'] = $videoLink->website->sub_name.' '.$videoLink->price.'元';
                    break;
            }
            $str.= $arr[$i]['websiteName'] . '&nbsp;&nbsp;' . $arr[$i]['price'] . '<br/>';
            $i++;
        }

        return $str;
    }

    public function getWebsite(){
        return $this->hasOne(FilmVideoWebsite::className(),['id' => 'website_id']);
    }

    public function getMovie(){
        return $this->hasOne(Movie::className(),['id' => 'movie_id']);
    }

    public static function getResourceNum($movie_id){
        return self::find()->where(['movie_id' => $movie_id])->count();
    }
}
