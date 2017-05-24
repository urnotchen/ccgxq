<?php

namespace frontend\modules\v1\models;

class AppVersion extends \frontend\models\AppVersion
{
    use \common\traits\LoadExceptionTrait;
    use \common\traits\ErrorsJsonTrait;
    use \common\traits\ValidateExceptionTrait;
    use \common\traits\SaveExceptionTrait;

    public function fields()
    {
        return [
            'os',
            'version',
            'is_imp',
            'title',
            'content',
        ];
    }

    public function compareVersion($version)
    {
        if ($version > $this->version) {

            \Yii::$app->blueliveMailer->sendEmail(
                "分镜版本错误",
                "当前客户端版本高于服务器版本。",
                ["2185136206@qq.com"]
            );

            $this->version = $version;

            return self::VERSION_IS_NEWEST;
        } else if ($version == $this->version) {

            return self::VERSION_IS_NEWEST;
        } else {

            return $this->is_imp;
        }
    }
}
