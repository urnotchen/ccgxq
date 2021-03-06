<?php

namespace common\models;

use common\models\queries\FilmChoiceUserQuery;
use common\traits\FindOrExceptionTrait;
use common\traits\SaveExceptionTrait;
use Yii;

/**
 * This is the model class for table "film_choice_user".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property integer $user_id
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 */
class FilmChoiceUser extends \yii\db\ActiveRecord
{

    use SaveExceptionTrait,FindOrExceptionTrait;

    const TYPE_SAW = 1 , TYPE_WANT = 2 , TYPE_SUBSCRIBE = 3;

    const TYPE_LIST = [self::TYPE_SAW,self::TYPE_WANT,self::TYPE_SUBSCRIBE];

    const ACTION_ADD = 1 , ACTION_DELETE = 2;

    const ACTION_LIST = [self::ACTION_ADD,self::ACTION_DELETE];

    const STATUS_NORMAL = 1 , STATUS_TRASH = 2;

    const PUSH_NO = 1 , PUSH_YES = 2;

    const SOURCE_ZHAN = 1 , SOURCE_OTHER = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_choice_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'user_id', 'type', 'created_at', 'updated_at','status','push','source'], 'integer'],
            [['movie_id','user_id', 'type'],'unique','targetAttribute'=>['movie_id','user_id', 'type']],
            [['status'],'default','value' => self::STATUS_NORMAL],
            [['push'],'default','value' => self::PUSH_NO],
        ];
    }

    public static function find(){

        return new FilmChoiceUserQuery(get_called_class());
    }

    public function behaviors()
    {/*{{{*/
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::classname(),
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
            'user_id' => 'User ID',
            'type' => 'Type',
            'push' => 'Push',
            'source' => 'Source',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getUserChoiceNum($movie_id,$type){

        return self::find()->where(['movie_id' => $movie_id,'type' => $type,'status' => self::STATUS_NORMAL])->count();
    }

    /*
    * 获取用户想看/看过/订阅的电影列表id
    * */
    public static function getMovieIds($type,$userId){

        return self::find()->select('movie_id')
            ->where(['type' => $type,'status' => self::STATUS_NORMAL,'user_id' => $userId])
            ->column();
    }
}
