<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $model backend\modules\stat\models\searches\StatUserActionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stat-user-action-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' =>[
            'class' => 'form-inline'
        ],
        'fieldClass' => '\bluelive\adminlte\widgets\ActiveField',
    ]); ?>


    <?= $form->field($model, 'statistics_time', ['options' => ['class' => 'form-group','style' => ['padding-left' => '0px']]])->label(false)->widget(
        DateRangePicker::className(),
        [
            'convertFormat'=>true,
            'options' => ['style' => 'height:34px; !important;', 'placeholder' => '时间筛选'],
            'pluginOptions'=>[
                'timePicker'=>true,
                'timePickerIncrement'=>30,
                'locale'=>[
                    'format'=>'Y-m-d',
                    'separator'  => ' ~ ',
                ]
            ]
        ]
    ); ?>


    <?= $form->field($model, 'sub_type')->dropDownList(\backend\modules\stat\models\StatUserAction::enum('sub_type')) ?>

    <?php // echo $form->field($model, 'daily') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
