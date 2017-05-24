<?php

namespace frontend\modules\v1\models;


class Message extends \frontend\models\Message
{

    public function fields()
    {
        return [
            'id',
            'status',
            'content',
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
