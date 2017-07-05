<?php

namespace backend\models;

class Reply extends \common\models\Reply
{
    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit = array_merge($inherit, [
            'isSender' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'is_sender',
                ],
                'value' => function ($event) {

                    return self::BOOL_FALSE;
                },
            ],
        ]);

        return $inherit;
    }
}

?>