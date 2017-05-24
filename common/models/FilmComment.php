<?php

namespace common\models;

use common\traits\FindOrExceptionTrait;
use Yii;

/**
 * This is the model class for table "film_comment".
 *
 * @property string $id
 * @property string $movie_id
 * @property string $user_id
 * @property string $username
 * @property string $userhome_url
 * @property integer $pic_id
 * @property integer $comment_date
 * @property integer $score
 * @property integer $good_num
 * @property string $comment
 * @property integer $updated_at
 */
class FilmComment extends \yii\db\ActiveRecord
{
    use FindOrExceptionTrait;
    /**
     * @inheritdoc
     */

    const TYPE_DOUBAN = 1 , TYPE_MTIME = 2 , TYPE_USER=3;

    const TYPE_RANGE = [self::TYPE_USER,self::TYPE_DOUBAN,self::TYPE_MTIME];



    public static function tableName()
    {
        return 'film_comment';
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
            [['id','movie_id', 'pic_id', 'star', 'good_num','type','created_at','updated_at','type'], 'integer'],
            [['username',], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 1000],
            [['movie_id','user_id'],'unique','targetAttribute'=>['movie_id','user_id']],
            [['user_id'],'safe'],
            [['type'],'default','value' => self::TYPE_USER],
            [['good_num'],'default','value' => 0],
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
            'username' => '用户名',
            'userhome_url' => '用户首页',
            'pic_id' => '用户头像',
            'comment_date' => '评论日期',
            'star' => '打分',
            'good_num' => '有用',
            'comment' => '内容',
            'updated_at' => '更新时间',
        ];
    }

    public static function find()
    {/*{{{*/
        return new \common\models\queries\FilmCommentQuery(get_called_class());
    }/*}}}*/


    public function getImage(){
        return $this->hasOne(Image::className(),['id' => 'pic_id']);
    }
}