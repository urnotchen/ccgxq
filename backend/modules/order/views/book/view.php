<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Book */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '群众预约', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            [
                'label' => '身份证号',
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

        ],
    ]) ?>

</div>
