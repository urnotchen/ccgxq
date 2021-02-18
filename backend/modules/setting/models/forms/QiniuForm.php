<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/7/10
 * Time: 11:07
 */

namespace backend\modules\setting\models\forms;

use yii\base\Model;

class QiniuForm extends Model{

    public $access_key, $secret_key , $bucket , $domain;

    public function rules()
    {
        return [
            [['access_key', 'secret_key', 'bucket' , 'domain'], 'required'],
            [['access_key', 'secret_key', 'bucket' , 'domain'], 'string'],
        ];
    }
}