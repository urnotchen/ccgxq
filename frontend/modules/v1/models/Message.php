<?php

namespace frontend\modules\v1\models;


class Message extends \frontend\models\Message
{

    public function fields()
    {
        return [
            'id',
            'status' => function($model){
                if($model->status == self::STATUS_NOT_READ) return 0;
                if($model->status == self::STATUS_YET_READ) return 1;
                return null;
            },
            'content',
            'movie_id' => function($model){
                return (int)$model->movie_id;
            },
            'local_name' => function($model){
                $titleList = explode(' ',$model->movie->title,2);
                $alias = count($titleList) == 2 ? $titleList[0] : '';
                return $alias;
            },
            'image' => function($model){
                return $model->movie->image;
            },
            'created_at' => function($model){
                return (int)$model->created_at;
            }
        ];
    }

    public function extraFields()
    {
        return [
            'movie',
            'image' => function($model){
                return $model->movie->image;
            }
        ];
    }

    public function getMovie(){
        return $this->hasOne(Movie::className(),['id' => 'movie_id']);
    }



    public static function toYetRead($id){

        $message = self::findOneOrException(['id' => $id]);

        $message->status = self::STATUS_YET_READ;
        $message->save();

        return $message;
    }

}
