<?php

namespace backend\modules\setting\controllers;

use Yii;
use yii\helpers\Json;

use backend\modules\setting\models\Staff;
use backend\modules\setting\models\Feedback;
use backend\modules\setting\models\UserDetails;
use backend\modules\setting\models\searches\FeedbackSearch;

class FeedbackController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'search-user', 'read', 'reply', 'send'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'footprint' => [
                'class' => \bluelive\components\FootprintBehavior::className(),
                'enableAction' => [
                    'index', 'search-user', 'read', 'reply', 'send'
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $rawParams = Yii::$app->request->queryParams;

        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search($rawParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 异步查询用户
     *
     * @param $from
     * @return array
     */
    public function actionSearchUser($from)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!$from) {

            return $out;
        }

        $userDetails = UserDetails::find()->select('user_id as id,nickname as text')->filterWhere([
            'like', 'user_id', $from
        ])->orFilterWhere([
            'like', 'nickname', $from
        ])->limit(50)->asArray()->all();

        $out['results'] = array_values($userDetails);

        return $out;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRead($id)
    {
        $model = Feedback::findOneOrException(['id' => $id]);
        $model->status = Feedback::STATUS_READ;

        return $model->save();
    }

    /**
     * @param $id
     * @return string
     */
    public function actionReply($id)
    {
        $model = Feedback::findOneOrException(['id' => $id], function ($query) {
            $query->with('replies');
        });
        $model->setUserReplyRead();
        $model->save();

        $userDetails = UserDetails::findOneOrException(['user_id' => $model->created_by]);

        return $this->renderAjax('_reply', [
            'model' => $model,
            'userDetails' => $userDetails
        ]);
    }

    /**
     * @return string
     */
    public function actionSend()
    {
        $fbId = Yii::$app->request->post('fb_id');
        $content = Yii::$app->request->post('content');

        $model = Feedback::findOneOrException(['id' => $fbId]);
        $model->generateReply($content);
        $model->status = Feedback::STATUS_REPLY;
        $model->save();

//        $baseInfo = Staff::getBaseInfo(Yii::$app->user->id);

        return Json::encode([
            'name' => '我',
            'avatar' => '没有',
            'content' => $content,
            'time' => Yii::$app->dateFormat->humanChatDateTime(time())
        ]);
    }
}

?>