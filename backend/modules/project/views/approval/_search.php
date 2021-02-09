<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ApprovalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approval-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'sequence') ?>

    <?= $form->field($model, 'agency') ?>

    <?php // echo $form->field($model, 'basic_sxlx') ?>

    <?php // echo $form->field($model, 'basic_bjlx') ?>

    <?php // echo $form->field($model, 'basic_sszt') ?>

    <?php // echo $form->field($model, 'basic_xscj') ?>

    <?php // echo $form->field($model, 'basic_cnbjsx') ?>

    <?php // echo $form->field($model, 'basic_fdbjsx') ?>

    <?php // echo $form->field($model, 'basic_is_charge') ?>

    <?php // echo $form->field($model, 'basic_dbsxccs') ?>

    <?php // echo $form->field($model, 'basic_zxfs') ?>

    <?php // echo $form->field($model, 'basic_jdtsfs') ?>

    <?php // echo $form->field($model, 'basic_blsj') ?>

    <?php // echo $form->field($model, 'basic_bldd') ?>

    <?php // echo $form->field($model, 'process') ?>

    <?php // echo $form->field($model, 'blclml') ?>

    <?php // echo $form->field($model, 'sltj') ?>

    <?php // echo $form->field($model, 'sfbz') ?>

    <?php // echo $form->field($model, 'sdyj') ?>

    <?php // echo $form->field($model, 'question') ?>

    <?php // echo $form->field($model, 'is_online') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
