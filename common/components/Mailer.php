<?php

namespace common\components;

class Mailer extends \yii\swiftmailer\Mailer
{




    public  function sendEmail($titles,$content,$emails)
    {
        $mail= \Yii::$app->ksmovieMailer->compose();
        $mail->setTo($emails);
        $mail->setSubject($titles);
        $mail->setHtmlBody($content);    //发布可以带html标签的文本
        if($mail->send())
            return 1;
        else
            return 0;
    }


}
