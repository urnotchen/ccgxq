<?php

namespace common\models;

use common\traits\FindOrExceptionTrait;
use common\traits\SaveExceptionTrait;
use Yii;

/**
 * This is the model class for table "film_recommend_user".
 *
 * @property integer $id
 * @property string $movie_id
 * @property integer $type
 * @property integer $star
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class FilmRecommendUser extends \yii\db\ActiveRecord
{

    use FindOrExceptionTrait;

    //电影斩官方生成的电影,根据官方推荐电影的评分数据给用户推荐的电影,用户评论了其他的电影(在电影斩外),电影斩补充推荐的数据(评分>7分)
    const TYPE_OFFICIAL = 1,TYPE_USER = 2,TYPE_COMMENT = 3,TYPE_COMMON = 4;
    //是否已经推荐了关联电影
    const STATUS_WAIT_RECOMMEND = 1 , STATUS_YET_RECOMMEND = 2;
    //(TYPE_OFFICIAL,TYPE_USER)只有这两个状态下才有这个choice参数,因为这两个表明了是电影斩推荐的
    //TYPE_COMMENT,代表着是外部的评价,不是电影斩内部的信息
    //这个是为了完全记录电影斩推荐的电影,用户的操作轨迹
    const CHOICE_DEFAULT = 1 , CHOICE_SAW = 2 , CHOICE_COLLECT = 3 , CHOICE_PASS = 4;
    //记录的来源
    const SOURCE_ZHAN = 1 , SOURCE_OTHER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_recommend_user';
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
    public function rules()
    {
        return [
            [['movie_id','user_id','type'],'required'],
            [['movie_id', 'user_id','type', 'star','status','source', 'created_at', 'updated_at','choice',], 'integer'],
            [['movie_id','user_id'],'unique','targetAttribute'=>['movie_id','user_id']],
            [['status'],'default','value' => self::STATUS_WAIT_RECOMMEND]
        ];
    }

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
            'star' => 'Star',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getFilmRecommend(){

        return $this->hasMany(FilmRecommend::className(),['movie_id' => 'movie_id']);

    }

    public function getMovie(){

        return $this->hasOne(Movie::className(),['id' => 'movie_id']);
    }

    /*
     * 获取评论超过3分的电影id列表
     * */
    public static function getGT3MovieIds($userId){

        return self::find()->select('movie_id')

//            ->where(['user_id' => $userId, 'choice' => [FilmRecommendUser::CHOICE_SAW],'status' => FilmRecommendUser::STATUS_WAIT_RECOMMEND])
            //不管是不是在电影斩里面评分的 都推荐关联的
            ->where(['user_id' => $userId,'status' => FilmRecommendUser::STATUS_WAIT_RECOMMEND])
            ->andWhere(['>=','star',3])
            ->column();
    }
}
