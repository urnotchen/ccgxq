<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "film_video_website".
 *
 * @property integer $id
 * @property string $name
 * @property string $sub_name
 */
class FilmVideoWebsite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_video_website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sub_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sub_name' => 'Sub Name',
        ];
    }
}
