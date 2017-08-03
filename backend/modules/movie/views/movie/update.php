<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use bluelive\adminlte\widgets\BoxWidget;
/* @var $this yii\web\View */
/* @var $model \backend\modules\movie\models\Movie */
/* @var $movieResource \backend\modules\movie\models\MovieResource */
/* @var $onlineResource \backend\modules\movie\models\OnlineResource */

$this->title = "修改电影 : {$model->title}";
?>
<div class="movie-update">
    <?php BoxWidget::begin();?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'release_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imdb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imdb_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'official_website')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'premiere')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'release_year')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'running_time')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'comment_num')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'score')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php BoxWidget::end();?>
</div>