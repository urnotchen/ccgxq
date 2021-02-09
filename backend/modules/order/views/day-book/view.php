<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DayBook */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Day Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="day-book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'order_id',
            'day_time',
            'book_time_arr',
            'book_num_arr',
            'pre_half_hour_people',
            'status',
            'booK_status_arr',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
