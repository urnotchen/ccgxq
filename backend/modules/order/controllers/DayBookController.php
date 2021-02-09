<?php

namespace backend\modules\order\controllers;

use backend\modules\order\models\Order;
use Yii;
use backend\modules\order\models\DayBook;
use backend\modules\order\models\search\BookSearchDay;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DayBookController implements the CRUD actions for DayBook model.
 */
class DayBookController extends Controller
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
     * Lists all DayBook models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearchDay();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DayBook model.
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
     * Creates a new DayBook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DayBook();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DayBook model.
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
     * Deletes an existing DayBook model.
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
     * Finds the DayBook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DayBook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DayBook::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * 每日一次 预约项目每日情况总表
     *
     * */
    public function actionCon(){

        $orders = Order::getOrdersForCrontab();


        foreach ($orders as$order){
            $morning_time = explode('-',$order['morning_time']);
            $morning_begin = strtotime($morning_time[0]);
            $morning_end = strtotime($morning_time[1]);
            $afternoon_time = explode('-',$order['afternoon_time']);
            $afternoon_begin = strtotime($afternoon_time[0]);
            $afternoon_end = strtotime($afternoon_time[1]);

            //七点开始
            $arr = [];
            $book_time_arr = [];
            $book_status_arr = [];
            $book_num_arr = [];
            $day_begin = strtotime('07:00');
            $day_end = strtotime('21:00');
            $book_total = 0;
            for($i = 0;$day_begin < $day_end;$i++){
                if($morning_begin <= $day_begin && $morning_end >= $day_begin){
                    $book_time_arr[$i] = 1;
                    $book_total++;}
                else
                    if($afternoon_begin <= $day_begin && $afternoon_end >= $day_begin){
                        $book_time_arr[$i] = 1;
                        $book_total++;}
                    else
                        $book_time_arr[$i] = 0;
                $day_begin += 1800;

                $book_num_arr[$i] = 0;
                $book_status_arr[$i] = 0;


            }
            //还是用json存吧
            $res = DayBook::addOneRecord([
                'order_id' => $order->id,
                'day_time' => strtotime('today'),
                'book_time_arr' => json_encode($book_time_arr),
                'book_num_arr' => json_encode($book_num_arr),
                'book_status_arr' => json_encode($book_status_arr),
                'pre_half_hour_people' => $order->pre_hour_people/2,
                'book_total' => $book_total,
                'book_num' => 0,
            ]);

        }
    }
}
