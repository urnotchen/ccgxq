<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\movie\models\search\MovieOnlineResourceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movie-online-resource-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',
        ],
        'fieldClass' => '\bluelive\adminlte\widgets\ActiveField',
    ]); ?>

    <?= $form->field($model, 'movie_title') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
