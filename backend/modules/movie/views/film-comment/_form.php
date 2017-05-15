<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FilmComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="film-comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'movie_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userhome_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pic_id')->textInput() ?>

    <?= $form->field($model, 'comment_date')->textInput() ?>

    <?= $form->field($model, 'score')->textInput() ?>

    <?= $form->field($model, 'good_num')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
