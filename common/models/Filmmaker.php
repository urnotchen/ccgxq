<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "filmmaker".
 *
 * @property string $id
 * @property string $pic_id
 * @property string $filmmaker_url
 * @property string $name
 * @property string $sex
 * @property string $constellation
 * @property string $birthday
 * @property string $birthplace
 * @property string $occupation
 * @property string $more_foreign_name
 * @property string $more_chinese_name
 * @property string $family_member
 * @property string $imdb
 * @property string $imdb_title
 * @property string $synopsis
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Filmmaker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filmmaker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'pic_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['synopsis'], 'string'],
            [['filmmaker_url', 'name', 'sex', 'constellation', 'birthday', 'birthplace', 'occupation', 'imdb', 'imdb_title'], 'string', 'max' => 255],
            [['more_foreign_name', 'more_chinese_name', 'family_member'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pic_id' => 'Pic ID',
            'filmmaker_url' => 'Filmmaker Url',
            'name' => 'Name',
            'sex' => 'Sex',
            'constellation' => 'Constellation',
            'birthday' => 'Birthday',
            'birthplace' => 'Birthplace',
            'occupation' => 'Occupation',
            'more_foreign_name' => 'More Foreign Name',
            'more_chinese_name' => 'More Chinese Name',
            'family_member' => 'Family Member',
            'imdb' => 'Imdb',
            'imdb_title' => 'Imdb Title',
            'synopsis' => 'Synopsis',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getImage(){
        return $this->hasOne(Image::className(),['id' => 'pic_id']);
    }

}
