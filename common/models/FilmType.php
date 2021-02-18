<?php

namespace common\models;

use common\traits\KVTrait;
use Yii;

/**
 * This is the model class for table "film_type".
 *
 * @property string $id
 * @property string $name
 */
class FilmType extends \yii\db\ActiveRecord
{
    use KVTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    public static function getTypeList(){
        return self::kv('id','name');
    }
}
