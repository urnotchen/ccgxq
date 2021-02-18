<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="box-body" >
    <div class="login-logo">
        <a href="#">用户注册</a>
    </div>
                    <div class="user-form">

                        <?php $form = ActiveForm::begin();?>


                        <span style="color: red;float: left">*</span>
                        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                        <span style="color: red;float: left">*</span>
                        <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
<!--                        <span style="color: red;float: left">*</span>-->
<!--                        --><?php //echo  $form->field($model, 'sure_password')->textInput(['maxlength' => true]) ?>
                        <span style="color: red;float: left">*</span>
                        <?= $form->field($model, 'real_name')->textInput(['maxlength' => true]) ?>
                        <span style="color: red;float: left">*</span>
                        <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
                        <span style="color: red;float: left">*</span>
                        <?= $form->field($model, 'certificates_type')->dropDownList($certificates_type_kv) ?>
                        <span style="color: red;float: left">*</span>
                        <?= $form->field($model, 'certificates_num')->textInput(['maxlength' => true]) ?>






                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? '注册' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

            </div>


