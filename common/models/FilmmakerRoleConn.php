<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "filmmaker_role_conn".
 *
 * @property string $id
 * @property string $movie_id
 * @property string $filmmaker_id
 * @property string $role_id
 */
class FilmmakerRoleConn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filmmaker_role_conn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'filmmaker_id', 'role_id'], 'integer'],
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
            'filmmaker_id' => 'Filmmaker ID',
            'role_id' => 'Role ID',
        ];
    }

    public static function getFilmmakerWorkNum($filmmaker_id){

        return self::find()->select('movie_id')->where(['filmmaker_id' => $filmmaker_id])->groupBy('movie_id')->orderBy(['movie_id' => SORT_DESC])->column();

    }
}
