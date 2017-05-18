<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/17
 * Time: 12:10
 */

namespace frontend\modules\v1\models;

class MovieIndex extends \frontend\models\MovieIndex{

    public function fields()
    {
        return [
           'diskResource' => function($model){
               $arr = [];

               if($model->movieDisk){
                   foreach($model->movieDisk as $eachMovieDisk){
                       $temp['id'] = $eachMovieDisk->id;
                       $temp['name'] = $eachMovieDisk->name;
                       $temp['url'] = $eachMovieDisk->url;
                       $temp['password'] = $eachMovieDisk->passwd;
                       $temp['definition'] = $eachMovieDisk->definition;
                       $arr[] = $temp;
                   }
               }
               return $arr;
           },
            'linkResource' => function($model){
                $arr = [];
                if($model->movieLink){
                    foreach($model->movieLink as $eachMovieLink){
                        $temp['id'] = $eachMovieLink->id;
                        $temp['name'] = $eachMovieLink->name;
                        $temp['url'] = $eachMovieLink->url;
                        $temp['definition'] = $eachMovieLink->definition;
                        $arr[] = $temp;
                    }
                }
                return $arr;
            }
        ];
    }

    public function extraFields()
    {

    }
}