<?php

namespace frontend\modules\v1\services;

use frontend\modules\v1\models\Reply;
use frontend\modules\v1\models\Feedback;
use frontend\modules\v1\models\forms\FeedbackForm;
use frontend\modules\v1\models\forms\ReplyTimeLine;


class FeedbackService extends \common\services\BizService
{

    /**
     * @param $rawParams
     * @return object
     * @throws \yii\base\Exception
     */
    public function postFeedback($rawParams)
    {
        $feedbackForm = new FeedbackForm();
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $feedbackForm->prepare($rawParams);

            //如果该用户已经反馈过 该版本app|卡包|卡片， 则后续反馈内容视为聊天内容
            $feedback = Feedback::getInstance([
                'app_v' => $feedbackForm->app_v,
                'device' => $feedbackForm->device,
                'os' => $feedbackForm->os,
                'created_by' => $this->getUser()
            ]);
            if ($feedback->isNewRecord) {
//return [$feedbackForm->getAttributes(),$feedback];
//                $feedback->created_at = null;die;
                $feedback->setAttributes($feedbackForm->getAttributes());
            } else {

                $feedback->status = Feedback::STATUS_UNREAD;
            }

            $feedback->save();

            $feedback->generateReply($feedbackForm->content);
            $transaction->commit();

        } catch (\yii\base\Exception $e) {
            $transaction->rollBack();

            throw $e;
        }

        return $feedback;
    }

    /**
     * @param $rawParams
     * @return array
     */
    public function getFeedback($rawParams)
    {
        $userId = $this->getUser()->id;

        $replyTimeline =  ReplyTimeLine::timeline($rawParams, function ($query) use ($userId) {
            //select * from feedbackMain where id in ...
            $query->andWhere([
                'user_id' => $userId,
            ]);
        });

        Reply::setClientReceiveRead($userId);

        return array_reverse($replyTimeline);
    }
}

?>