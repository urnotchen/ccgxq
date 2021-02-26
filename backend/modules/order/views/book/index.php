<?php

use backend\modules\order\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\search\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '在线预约';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <?php  echo $this->render('_search', ['model' => $searchModel  ,    'order_kv' => Order::getOrderKv(),
]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [


            ['class' => 'yii\grid\SerialColumn'],

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
                'attribute' => 'book_end_time',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->formatHI($model->book_end_time);
                },
            ],
            [
                'label' => '证件号码',
                'format'=>'raw',
                'value' => function($model){

                    return $model->user->certificates_num;
                },
            ],
            [
                'attribute' => 'created_by',
                'format'=>'raw',
                'value' => function($model) use ($user_kv){

                    return $user_kv[$model->created_by];
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>
