<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\search\BookSearchDay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="day-book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'day_time') ?>

    <?= $form->field($model, 'book_time_arr') ?>

    <?= $form->field($model, 'book_num_arr') ?>

    <?php // echo $form->field($model, 'pre_half_hour_people') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'booK_status_arr') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
