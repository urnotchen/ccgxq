<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->widget(
        \kartik\select2\Select2::className(),
        [
            'data' => $category_kv,
            'language' => 'zh-CN',
            'pluginOptions' => [
                'allowClear' => true
            ],
            'options' => ['placeholder' => '项目类型'],
        ]
    );?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
