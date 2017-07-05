<?php

namespace frontend\modules\v1\models;


class Reply extends \frontend\models\Reply
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

                    return self::BOOL_TRUE;
                },
            ],
        ]);

        return $inherit;
    }

    public function fields()
    {
        return [
            'id',
            'from' => function(self $model) {
                return $model->is_sender ?
                    UserDetails::findOne(['user_id' => $model->user_id])->nickname :
                    self::OFFICIAL_NAME;
            },
            'to' => function($model) {
                return $model->is_sender ?
                    self::OFFICIAL_NAME :
                    UserDetails::findOne(['user_id' => $model->user_id])->nickname;
            },
            'content',
            'created_at',
        ];
    }

    public static function setClientReceiveRead($userId)
    {

        return self::updateAll(
            ['status' => self::STATUS_READ],
            ['user_id' => $userId, 'is_sender' => self::BOOL_FALSE]
        );
    }
}

?>