<?php

namespace frontend\modules\v1\models;


class Feedback extends \frontend\models\Feedback
{
    use \common\traits\ModelPrepareTrait;
//    use \common\traits\SaveExceptionTrait;

    public function fields()
    {
        return [
            'app_v',
            'device',
            'os',
            'created_at',
        ];
    }

    /**
     * @param $content
     * @return bool|Reply
     */
    public function generateReply($content)
    {
        if (empty($this->created_by)) {

            return false;
        }

        $reply = new Reply();
        $reply->fb_id = $this->id;
        $reply->user_id = $this->created_by;
        $reply->content = $content;
        return $reply->save();
//        return $reply->getErrors();
    }
}

?>