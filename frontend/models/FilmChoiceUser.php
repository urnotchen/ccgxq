<?php

namespace frontend\models;

use frontend\modules\v1\models\FilmComment;
use frontend\modules\v1\models\FilmType;
use frontend\modules\v1\models\FilmTypeConn;
use frontend\modules\v1\models\forms\UserActionForm;
use yii\helpers\ArrayHelper;

class FilmChoiceUser extends \common\models\FilmChoiceUser
{

    /*
     * 添加/删除用户的订阅/想看/已看等个人
     * */
    public static function userAction($movie_id,$type,$action,$user_id){

        switch($action){
            case self::ACTION_ADD:
                $choice = self::findOne(['movie_id' => $movie_id,'user_id' => $user_id,'type' => $type,'status' => self::STATUS_TRASH]);
                if($choice){
                    $choice->status = self::STATUS_TRASH;
                }else {
                    $choice = new static;
                    $choice->movie_id = $movie_id;
                    $choice->user_id = $user_id;
                    $choice->type = $type;
                }

                $choice->save();
                break;
            case self::ACTION_DELETE:
                $choice = self::findOneOrException(['movie_id' => $movie_id,'user_id' => $user_id,'type' => $type,'status' => self::STATUS_NORMAL]);
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
            ->join('join',FilmComment::tableName(),FilmComment::tableName().'.user_id='.self::tableName().'.user_id')
            ->where([self::tableName().'.type' => $type,self::tableName().'.user_id' => $user_id,self::tableName().'.status' => self::STATUS_NORMAL])
            ->andWhere([FilmComment::tableName().'.type' => FilmComment::TYPE_USER])
            ->groupBy(FilmComment::tableName().'.star')->asArray()->all();

        return $res;
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
}
