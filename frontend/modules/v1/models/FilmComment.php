<?php

namespace frontend\modules\v1\models;

class FilmComment extends \frontend\models\FilmComment
{

    public function fields()
    {
        return [
            'id' => function($model){
                return (int)$model->id;
            },
            'star',
            'good_num',
            'comment',
            'username' => function($model){
                if($model->username){
                    return $model->username;
                }else{
                    //todo 返回用户名
//                    return
                }
            },
            'source' => function($model){
                return $model->type;
            }
        ];
    }

    public function extraFields()
    {
        return [
            'image',
        ];
    }

    public function getImage(){
        return $this->hasOne(Image::className(),['id' => 'pic_id']);
    }
}
