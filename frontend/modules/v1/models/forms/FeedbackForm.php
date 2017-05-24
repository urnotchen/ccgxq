<?php

namespace frontend\modules\v1\models\forms;

class FeedbackForm extends \frontend\modules\v1\models\Feedback
{
    public $content;

    public function rules()
    {
        $inherit = parent::rules();
        $inherit[] = ['content', 'string', 'max' => 255];
        $inherit[] = ['content', 'required'];

        return $inherit;
    }

}

?>