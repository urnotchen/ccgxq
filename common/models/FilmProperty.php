<?php

namespace common\models;


use Codeception\Exception\ElementNotFound;
use common\models\queries\FilmPropertyQuery;
use common\models\queries\MovieQuery;
use common\traits\EnumTrait;
use common\traits\KVTrait;
use common\traits\SaveExceptionTrait;
use rmrevin\yii\fontawesome\FA;
use Yii;
use common\traits\FindOrExceptionTrait;


/**
 * This is the model class for table "film_property".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property integer $property
 * @property integer $sequence
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class FilmProperty extends \yii\db\ActiveRecord
{
    use EnumTrait,FindOrExceptionTrait,KVTrait,SaveExceptionTrait;

    //属性:最新,热门,精选,官方推荐
    const PROPERTY_NEWEST = 1 , PROPERTY_HOT = 2 ,PROPERTY_RECOMMEND_OFFICIAL = 4;

    //state of movie's property
    const STATUS_NORMAL = 0 , STATUS_TRASH = 1;


    //可进行添加属性的属性id列表
    public static $propertyList = [self::PROPERTY_NEWEST,self::PROPERTY_HOT,self::PROPERTY_RECOMMEND_OFFICIAL];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'film_property';
    }

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'blameable' => \yii\behaviors\BlameableBehavior::className()
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id','property'], 'required'],
            [['id', 'movie_id', 'property', 'sequence','status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            ['movie_id','exist','targetClass' => Movie::className(),'targetAttribute' => 'id'],
            [['movie_id','property'],'unique','targetAttribute' => ['movie_id','property']]
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
            'property' => 'Property',
            'sequence' => 'Sequence',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function find(){

        return new FilmPropertyQuery(get_called_class());
    }


    public static function getEnumData(){

        return [
            'property' => [
                self::PROPERTY_NEWEST => '最新',
                self::PROPERTY_HOT => '热门',
//                self::PROPERTY_SELECTED => '精选',
                self::PROPERTY_RECOMMEND_OFFICIAL => '官方推荐',
            ],
        ];
    }

    /*
     * verify whether the property is in the property list
     * @params int $property_id from js from FilmProperty's constant
     * @throws ElementNotFound
     * */
    public static function validateProperty($property_id){

        if(!in_array($property_id,self::$propertyList)){
            throw new ElementNotFound('property is not in property list,please check it');
        }
    }

    /*
     * get a movie's all properties
     * @params int $movie_id from table movie's id
     * @throws 404 NOT FOUND
     * @return array
     * */
    public static function getMovieProperties($movie_id){

        //whether a parameter is reasonable
        Movie::findOneOrException(['id' => $movie_id]);

        $res = self::find()->select('property')->where(['movie_id' => $movie_id,'status' => self::STATUS_NORMAL])->column();

        return $res?$res:[];
    }

    /*
     * get movie's sequence possible trajectory
     * @params $id from table film_property's id
     * @throws 404 (id is not exists in film_property)
     * @return array
     * */
    public static function getMotionPossible($id){

        $property = self::findOneOrException(['id'=> $id]);

        if($property->sequence){

            $upMotion = self::find()->where(['>','sequence',$property->sequence])->andWhere(['property' => $property->property])->count();
            $downMotion = self::find()->where(['<','sequence',$property->sequence])->andWhere(['property' => $property->property])->count();
            $motion['up'] = $upMotion?True:False;
            $motion['down'] = $downMotion?True:False;

        }else{

            $motion['up'] = True;
            $motion['down'] = False;

        }

        return $motion;
    }

    public static function getSequenceMax($property){

        self::validateProperty($property);

        return self::find()->where(['property' => $property])->max('sequence');

    }
}
