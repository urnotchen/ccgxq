<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'value' => $username]) ?>

    <?= $form->field($model, 'real_name')->textInput(['maxlength' => true,'value' => $realname]) ?>

    <?= $form->field($model, 'mark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'value'=>$email]) ?>

    <?php $task_user->is_weibo_author = $arr[0] ;?>
    <?= $form->field($task_user, 'is_weibo_author')->checkbox(['1'=>'微博作者']) ?>
    <?php $task_user->is_weixin_author = $arr[1]?>
    <?= $form->field($task_user, 'is_weixin_author')->checkbox(['1'=>'微信作者']) ?>


    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true,'value' => $pwd]) ?>
    <?php endif; ?>

    <?= $form->field($assignment, 'roles')->checkboxList($roles) ?>

    <?= $form->field($task_user, 'weibo_account')->checkboxList($account_list)->label("微博任务账号选择") ?>

    <?= $form->field($model, 'status')->radioList(User::enum('status')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
