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
    public static function tableName()
    {
        return 'film_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'pic_id', 'comment_date', 'score', 'good_num', 'updated_at'], 'integer'],
            [['user_id', 'username', 'userhome_url'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 1000],
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
            'score' => '打分',
            'good_num' => '有用',
            'comment' => '内容',
            'updated_at' => '更新时间',
        ];
    }

    public function getImage(){
        return $this->hasOne(Image::className(),['id' => 'pic_id']);
    }
}
