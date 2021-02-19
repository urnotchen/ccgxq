<?php

use backend\modules\order\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\search\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel  ,    'order_kv' => Order::getOrderKv(),
]); ?>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [


            'id',
            [
                'attribute' => 'order_id',
                'format'=>'raw',
                'value' => function($model){

                    return $model->order->name;
                },
            ],
            [
                'attribute' => 'day_time',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->formatYMD($model->day_time);
                },
            ],
            [
                'attribute' => 'book_begin_time',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->formatHI($model->book_begin_time);
                },
            ],
            [
                'attribute' => 'book_begin_time',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->formatHI($model->book_end_time);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
