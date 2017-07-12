<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\modules\stat\models\searches\StatMovieSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stat-movie-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' =>[
            'class' => 'form-inline'
        ],
        'fieldClass' => '\bluelive\adminlte\widgets\ActiveField',
    ]); ?>

    <?= $form->field($model, 'type')->dropDownList(\backend\modules\stat\models\StatMovie::getEnumData()['type']) ?>
    <?= $form->field($model, 'day')->dropDownList(\backend\modules\stat\models\StatMovie::getEnumData()['type']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
