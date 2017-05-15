<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Filmmaker */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filmmaker-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pic_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filmmaker_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'constellation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthplace')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'occupation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'more_foreign_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'more_chinese_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'family_member')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imdb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imdb_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'synopsis')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
