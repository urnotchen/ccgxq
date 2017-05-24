<?php

namespace frontend\modules\v1\traits;

trait SyncTrait
{
    public $cuuid;

    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit = array_merge($inherit, [
            'createdAt' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
                'value' => function ($event) {

                    return $this->updated_at;
                },
            ]
        ]);

        return $inherit;
    }

    public function rules()
    {
        $inherit = parent::rules();
        $inherit[] = ['updated_at', 'required'];
        $inherit[] = ['cuuid', 'string'];
        $inherit[] = ['cuuid', 'required', 'on' => self::SCENARIO_CREATE];

        return $inherit;
    }

}

?>