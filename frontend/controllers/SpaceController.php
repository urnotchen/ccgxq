<?php
namespace frontend\controllers;

use frontend\models\Book;
use frontend\models\Deal;
use frontend\models\FrontUser;
use frontend\models\Message;
use yii\web\Controller;

class SpaceController extends Controller{

    public function actionIndex(){
        $user = FrontUser::getInfo();
        return $this->render('index',[
            'user' => $user,
        ]);
    }
    public function actionInfo(){
        $user = FrontUser::getInfo();
        $user['created_at'] = \Yii::$app->timeFormatter->normalYmd($user['created_at']);
        return $this->render('info',[
            'user' => $user,
        ]);
    }
    public function actionOrder(){

        return $this->render('order',[
            'books' => Book::getBooks(),
        ]);
    }
    public function actionApproval(){

        return $this->render('approval',[
            'deals' => Deal::getDeals(),
        ]);
    }
    public function actionMessage(){

        return $this->render('message',[
            'messages' => Message::getMessages(),
        ]);
    }
}