<?php

namespace common\traits;

use yii\helpers\Json;

/**
 * ErrorsJsonTrait class file.
 * @Author haoliang
 * @Date 19.11.2015 15:50
 */
trait ErrorsJsonTrait
{

    public function getErrorsJson()
    {
        if (!$this->hasErrors()) {
            return '';
        }
        return Json::encode($this->getErrors());
    }

}
