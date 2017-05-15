<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="movie-search ">


    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',
        ],
        'fieldClass' => '\bluelive\adminlte\widgets\ActiveField',
    ]); ?>


    <?= $form->field($model, 'title') ?>

    <?php  echo $form->field($model, 'actor') ?>

    <?php  echo $form->field($model, 'producer_country') ?>

    <?php  echo $form->field($model, 'release_year')->dropDownList(range(1900,date("Y"))) ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
