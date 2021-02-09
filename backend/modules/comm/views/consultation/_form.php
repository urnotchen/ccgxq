<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Consultation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patient_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'age')->textInput() ?>

    <?= $form->field($model, 'sex')->textInput() ?>

    <?= $form->field($model, 'disease_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'illness')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'need_consultation')->textInput() ?>

    <?= $form->field($model, 'consultation_at')->textInput() ?>

    <?= $form->field($model, 'consultation_people')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
