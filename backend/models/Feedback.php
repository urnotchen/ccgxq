<?php

namespace backend\models;

class Feedback extends \common\models\Feedback
{
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
    }
}

?>