<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use backend\modules\rights\models\Item;

/* @var $this yii\web\View */
/* @var $model backend\modules\rights\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

        <?= $form->field($model, 'roles')->checkboxList(Item::getAllRoles([$model->name])); ?>

        <?= $form->field($model, 'permissions')->checkboxList(Item::getAllPermissions()); ?>

        <div class="form-group">
            <?= Html::submitButton(
                'Save',
                ['class' => 'btn btn-success']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>

   <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>
