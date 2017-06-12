<?php

namespace frontend\modules\v1\models;

use yii\helpers\ArrayHelper;

class FilmChoiceUser extends \frontend\models\FilmChoiceUser
{

    public function fields()
    {
        return [
            'id'
        ];
    }

    public function extraFields()
    {
        return [
            'movie',
            'image' => function($model){
                return $model->movie->image;
            },
            'websiteResource' => function($model){
                return $model->movie->websiteResource;
            },
            'onlineResource' => function($model){
                if($model->movie->onlineResource){
                    return $model->movie->onlineResource;
                }
                if($model->onlineResource2){
                    return $model->movie->onlineResource2;
                }
            }
        ];
    }

    public function getMovie(){

        return $this->hasOne(Movie::className(),['id' => 'movie_id']);
    }

    /*
     * 添加/删除用户的订阅/想看/已看等个人
     * */
    public static function userAction($user_id,$movie_id,$type,$action){

        switch($action){
            case self::ACTION_ADD:
                $choice = self::findOne(['movie_id' => $movie_id,'user_id' => $user_id,'type' => $type]);
                if($choice){
                    if($choice->status == self::STATUS_NORMAL){
                        $choice->status = self::STATUS_NORMAL;
                    }else{
                        $choice->status = self::STATUS_NORMAL;
                    }
                }else {
                    $choice = new static;
                    $choice->movie_id = $movie_id;
                    $choice->user_id = $user_id;
                    $choice->type = $type;
                }

                $choice->save();
                break;
            case self::ACTION_DELETE:
                $choice = self::findOne(['movie_id' => $movie_id,'user_id' => $user_id,'type' => $type]);
//                if(!$choice){
//                    throw new \yii\web\HttpException(
//                        404,
//                        'user does not have this action',
//                        \common\components\ResponseCode::INVALID_CANCEL_ACTION
//                    );
//                }
                $choice->status = self::STATUS_TRASH;
                $choice->save();
                break;
            default :
                throw new \yii\web\HttpException(
                    404,
                    'user action not found',
                    \common\components\ResponseCode::INVALID_USER_ACTION
                );
        }
        return $choice;
    }

    /*
     * 获取获取看过/想看/订阅列表中的星数
     * */
    public static function getStarNum($user_id,$type){

        $res = self::find()->select([FilmComment::tableName().'.star','COUNT(`film_comment`.id) as star_num'])
            ->join('join',FilmComment::tableName(),FilmComment::tableName().'.user_id='.self::tableName().'.user_id' .' and '.FilmComment::tableName().'.movie_id='.self::tableName().'.movie_id' )
            ->where([self::tableName().'.type' => $type,self::tableName().'.user_id' => $user_id,self::tableName().'.status' => self::STATUS_NORMAL])
            ->andWhere([FilmComment::tableName().'.type' => FilmComment::TYPE_USER])
            ->andWhere([FilmComment::tableName().'.type' => FilmComment::TYPE_USER])
            ->groupBy(FilmComment::tableName().'.star')->asArray()->all();
        $res = ArrayHelper::map($res,'star','star_num');
        $name = ['one_star','two_star','three_star','four_star','five_star'];
        $arr = [];
        for($i = 0; $i < 5 ; $i ++){
            $arr[$name[$i]] = isset($res[$i + 1])?(int)$res[$i + 1]:0;
        }
        return $arr;
    }

    /*
     * 获取看过/想看/订阅列表中的电影类型数量
     * */
    public static function getTypeNum($user_id,$movieType){

        $res = self::find()->select([FilmType::tableName().'.name','COUNT(film_type_conn.type_id) as type_num'])
            ->join('join',FilmTypeConn::tableName(),FilmTypeConn::tableName().'.movie_id='.self::tableName().'.movie_id')
            ->join('join',FilmType::tableName(),FilmType::tableName().'.id='.FilmTypeConn::tableName().'.type_id')
            ->where([self::tableName().'.type' => $movieType,self::tableName().'.user_id' => $user_id,self::tableName().'.status' => self::STATUS_NORMAL])
            ->groupBy(FilmTypeConn::tableName().'.type_id')->asArray()->all();

        return $res;
    }

    public static function getUserTypeNum($user_id,$seeType){

        return  self::find()->where(['status' => self::STATUS_NORMAL,'user_id' => $user_id,'type'=>$seeType])->count();
    }

    /*
     * 用户是否看过/想看/订阅
     * */
    public  static function existAction($movieId,$type){

        $userId = \Yii::$app->getUser()->id;
        return self::findOne(['movie_id' => $movieId,'type' => $type,'user_id' => $userId,'status' => self::STATUS_NORMAL])?1:0;
    }


}
