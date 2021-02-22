<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Selection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selection-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'department_id')->widget(\kartik\select2\Select2::className(), [
        'data' => $department,
    ])->label('请选择要评价的部门') ?>

    <?= $form->field($model, 'grade')->radioList($grade)->label('您对当前科室评分') ?>

    <?= $form->field($model, 'advise')->textarea(['rows' => 6])->label('请您对部门存在的主要问题及您的意见')?>

    <div class="form-group">
        <?= Html::submitButton('提交' , ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
