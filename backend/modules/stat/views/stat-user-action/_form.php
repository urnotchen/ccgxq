<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\stat\models\StatUserAction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stat-user-action-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'day')->textInput() ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'sub_type')->textInput() ?>

    <?= $form->field($model, 'daily')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
