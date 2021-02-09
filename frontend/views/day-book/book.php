<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput(['maxlength' => true,'disabled' => true,'value' => $order_name]) ?>

    <?= $form->field($model, 'day_time')->textInput(['maxlength' => true,'disabled' => true,'value' => $day_time]) ?>

    <?= $form->field($model, 'book_time_arr_val')->radioList($book_kv) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '预约' : '修改预约', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
