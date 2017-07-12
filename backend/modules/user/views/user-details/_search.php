<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\searches\UserDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'nickname') ?>

    <?= $form->field($model, 'avatar') ?>

    <?= $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'birth') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'career') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
