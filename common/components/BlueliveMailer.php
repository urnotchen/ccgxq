<?php

namespace common\components;

class BlueliveMailer extends \yii\base\Object
{

    public $api = 'http://notification.bluelive.me/api/compose';

    /**
     * @param $title
     * @param $content
     * @param array $emails
     * @param $created_by
     * @return mixed
     */
    public function sendEmail($title, $content, array $emails, $created_by = 'Robot')
    {
        $data = [
            'subject' => $title,
            'content' => $content,
            'send_to'  => \yii\helpers\Json::encode($emails),
            'created_by' => $created_by,
        ];
        return $this->send(\yii\helpers\Json::encode($data));
    }

    /**
     * @param $dataString
     * @return bool
     * @throws \yii\web\HttpException
     */
    public function send($dataString)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($dataString)
            )
        );
        $output = curl_exec($ch);

        curl_close($ch);

        if ($output === false) {
            throw new \yii\web\HttpException(500, 'send mail failed.');
        }

        return true;
    }
}
