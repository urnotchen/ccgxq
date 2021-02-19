<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\search\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',
        ],
        'fieldClass' => 'backend\widgets\ActiveField',
    ]); ?>


    <?= $form->field($model, 'order_id')->widget(
        \kartik\select2\Select2::className(),
        [
            'data' => $order_kv,
            'language' => 'zh-CN',
            'pluginOptions' => [
                'allowClear' => true
            ],
            'options' => ['placeholder' => '预约项目'],
        ]
    ) ?>

    <?= $form->field($model, 'push_time', ['options' => ['class' => 'form-group']])->label(false)->widget(
        \kartik\daterange\DateRangePicker::className(),
        [
            'options' => ['placeholder' => '筛选时间段'],
            'pluginOptions'=>[
                'locale'=>[
                    'format'=>'Y-m-d',
                    'separator'=>' ~ ',
                ],
                'opens'=>'right'
            ],
        ]
    ) ?>



    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
