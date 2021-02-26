<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Partment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'partname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'num')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
