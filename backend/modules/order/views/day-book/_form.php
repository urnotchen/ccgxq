<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DayBook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="day-book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'day_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_time_arr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_num_arr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pre_half_hour_people')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'booK_status_arr')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
