<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use backend\modules\rights\models\Item;
use backend\modules\rights\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\rights\models\Assignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assignment-form">

    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id')->dropDownList($users, ['prompt' => '请选择']) ?>

        <?= $form->field($model, 'roles')->checkboxList($roles) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

   <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>
