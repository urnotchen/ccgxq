<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\setting\models\AppVersion;

/* @var $this yii\web\View */
/* @var $model AppVersion */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="app-version-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'access_key')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'secret_key')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bucket')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>



        <div class="form-group">
            <?=
                Html::submitButton('修改', ['class' => 'btn btn-primary'])
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