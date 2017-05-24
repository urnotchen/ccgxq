<?php

namespace frontend\modules\v1\controllers;

use Yii;
use frontend\modules\v1\models\AppVersion;
use frontend\modules\v1\models\forms\AppVersionForm;

/**
 * AppVersionController implements the CRUD actions for AppVersion model.
 */
class AppVersionController extends \frontend\components\rest\Controller
{

    public function verbs()
    {
        return [
            'get-version' => ['get'],
        ];
    }

    /**
     * 获取APP最新版本
     * @return array|null|\yii\db\ActiveRecord
     */
    public function actionVersion()
    {
        $rawParams = Yii::$app->getRequest()->get();
        $form = New AppVersionForm;
        $form->prepare($rawParams);
        
        $lastVersion = AppVersion::find()->where([
            'os' => $form->os
        ])->orderBy('id DESC')->one();

        $lastVersion->is_imp = $lastVersion->compareVersion($form->version);

        return $lastVersion;
    }

}
