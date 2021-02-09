<?php

namespace frontend\controllers;

use frontend\models\DayBook;
use frontend\models\Order;
use Yii;
use frontend\models\Book;
use backend\modules\order\models\search\BookSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($order_id)
    {

        $apply_order_time = strtotime('today');
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) &&$model->validate()&& $model->save()) {
            DayBook::updateRecord(DayBook::OPERATION_BOOK,$model->day_book_id,$model->book_time_arr_val);
            return $this->render('book_ok');
        } else {
            $order = Order::findOne($order_id);
            $day_book = DayBook::findByTimeByOrderId($order_id,$apply_order_time);
            if($order['status'] == Order::STATUS_NORMAL){
                if($day_book['status'] == DayBook::STATUS_NORMAL) {
                    $book_kv = [];
                    $book_time = json_decode($day_book['book_time_arr']);
                    $book_num = json_decode($day_book['book_num_arr']);
                    $seven_am = $day_book->day_time + 7 * 3600;;
                    $model->day_book_id = $day_book->id;
                    $model->order_id = $order_id;
                    $model->day_time = $day_book->day_time;
                    for ($i = 0; $i < count($book_time); $i++) {
                        if ($book_time[$i] == 1 && $book_time[$i + 1] == 1) {
                            $book_kv[$i] = date("H:i", $seven_am + 1800 * $i) . '-' . date("H:i", $seven_am + 1800 * ($i + 1)) . " 已预约人数：" . $book_num[$i] . '; 剩余预约人数:' . ($day_book->pre_half_hour_people - $book_num[$i]);
                        }
                    }
                    return $this->render('book', [
                        'model' => $model,
                        'day_time' => date('Y-m-d'),
                        'order_name' => $order->name,
                        'book_kv' => $book_kv,
                    ]);
                }else if($day_book['status'] == DayBook::STATUS_OVER){
                    //人满
                    return $this->render('book_over',[
                        'day_time' => date('Y-m-d'),
                        'model' => $model,
                        'order_name' => $order->name,
                    ]);
                }
            }else if($order['status'] == Order::STATUS_STOP){
                //暂停预约
            }else if($order['status'] == Order::STATUS_OVER ){
                //人满
            }else if($order['status'] == Order::STATUS_DELETE){
                //已删除
            }
            return $this->render('book', [
                'model' => $model,
            ]);
        }
    }

    public function actionCancel($book_id){

        $book = Book::findOne($book_id);
        if($book['created_by'] != Yii::$app->user->id){
            throw new Exception('您无法取消别人的预约');
        }
        $book['status'] = Book::STATUS_CANCEL;
        $day_book = DayBook::findOne($book['day_book_id']);
        DayBook::updateRecord(DayBook::OPERATION_CANCEL,$book['day_book_id'],$book['$book_time_arr_val']);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
