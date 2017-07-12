<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\stat\models\StatMovie */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stat-movie-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'day')->textInput() ?>

    <?= $form->field($model, 'movie_id')->textInput() ?>

    <?= $form->field($model, 'num')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
