<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\setting\models\AppVersion;

/* @var $this yii\web\View */
/* @var $model AppVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-version-form">

    <?php $form = ActiveForm::begin(['id' => 'form-app-version']); ?>

    <?= $form->field($model, 'os')->dropDownList(AppVersion::enum('os')) ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_imp')->dropDownList(AppVersion::enum('is_imp')) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= $model->isNewRecord
            ? Html::submitButton('添加' ,['class' => 'btn btn-success'])
            : Html::button('修改', ['class' => 'btn btn-primary btn-shortcut'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs( <<<JS
    $.app_version_ajax();
JS
);
?>