<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\search\FilmCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="film-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['user-index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',
        ],
        'fieldClass' => '\bluelive\adminlte\widgets\ActiveField',
    ]); ?>




    <?php  echo $form->field($model, 'comment') ?>
    <?php  echo $form->field($model, 'type')->hiddenInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
