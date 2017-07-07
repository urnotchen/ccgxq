<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "scrapy_update_process".
 *
 * @property string $id
 * @property integer $scrape_date
 * @property string $movie_url
 * @property string $movie_id
 * @property integer $status
 * @property string $referer
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $scrape_times
 */
class ScrapyUpdateProcess extends \yii\db\ActiveRecord
{
    const DOUBAN_URL = 'https://movie.douban.com/', DOUBAN_MOVIE_URL = 'https://movie.douban.com/subject/';

    const STATUS_WAIT_SCRAPE = 0 , STATUS_ALREADY_SCRAPED = 200 , STATUS_ERROR_404 = 404;

    public function behaviors()
    {/*{{{*/
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::classname(),
        ];
    }/*}}}*/

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scrapy_update_process';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scrape_date', 'movie_id', 'status', 'created_at', 'updated_at', 'error_times'], 'integer'],
            [['movie_url', 'referer'], 'string', 'max' => 255],
            [['status'],'default','value' => self::STATUS_WAIT_SCRAPE],
            [['error_times'],'default','value' => 0],
            [['scrape_date','movie_id'],'unique','targetAttribute' => ['scrape_date', 'movie_id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scrape_date' => 'Scrape Date',
            'movie_url' => 'Movie Url',
            'movie_id' => 'Movie ID',
            'status' => 'Status',
            'referer' => 'Referer',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'error_times' => 'Scrape Times',
        ];
    }
}
