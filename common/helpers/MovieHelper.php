<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/6/16
 * Time: 9:23
 */
namespace common\helper;

class MovieHelper extends \yii\base\Object{

    /*
     * 获取电影中文名
     * @param fullName eg:歌剧魅影 The Phantom of the Opera
     * */
    public static function getChineseName($fullName){

return 1;
        $titleList = explode(' ',$fullName,2);

        return $titleList?$titleList[0]:'';
    }

    /*
     * 获取电影本土名
     * @param fullName eg:放牛班的春天 Les choristes
     * */
    public static function getLocalName($fullName){

        if(!$fullName){
            return null;
        }
        $titleList = explode(' ',$fullName,2);
        return count($titleList) == 2 ? $titleList[1] : '';


    }

    public static function test(){
        return 2;
    }
}