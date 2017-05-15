<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FilmmakerRoleConn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filmmaker-role-conn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'movie_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filmmaker_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
