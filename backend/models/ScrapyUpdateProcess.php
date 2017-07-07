<?php

namespace backend\models;

class ScrapyUpdateProcess extends \common\models\ScrapyUpdateProcess
{

    /*
     * 查找某一天采集失败或是没完成(只要状态码不是200的都算)的AR
     * @params $timestamp 时间戳
     * */
    public static function getReScrapeId($timestamp){

        return self::find()
            ->where(['scrape_date' => $timestamp])
            ->andwhere(['not',['status' => self::STATUS_ALREADY_SCRAPED]])
            ->andWhere(['<','error_times',4])->all();

    }

    /*
     * 添加待采集的豆瓣电影(为定时接口提供)
     * */
    public static function addRecord($scrapeTimestamp,$movieId,$error_times = 0,$referer = self::DOUBAN_URL,$movieUrl = null){

        $record = new self;

        $record->scrape_date = $scrapeTimestamp;
        $record->movie_id = $movieId;
        $record->movie_url = $movieUrl?$movieUrl:self::DOUBAN_MOVIE_URL.$movieId.'/';
        $record->referer = $referer;
        $record->error_times = $error_times;

        $record->save();
    }

}
