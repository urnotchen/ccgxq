<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
?>

<div class="user-search row">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-sm-2">
    <?= $form->field($model, 'id', ['options' => ['class' => 'search-field-select2']])->label(false)->widget(
        \kartik\select2\Select2::className(),
        [
            'data' => $user_kv,
            'language' => 'zh-CN',
            'pluginOptions' => [
                'allowClear' => true
            ],
            'options' => ['placeholder' => '员工'],
        ]
    ) ?>
    </div>
    <div class="col-sm-2">
    <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('用户名和真实姓名')])->label(false);  ?>
    </div>
    <div class="col-sm-2">
    <?= $form->field($model, 'status')->dropDownList($status_kv, ['prompt' => '状态'])->label(false);  ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('筛选', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
