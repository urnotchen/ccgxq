<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\search\FilmCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="film-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'movie_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'userhome_url') ?>

    <?php // echo $form->field($model, 'pic_id') ?>

    <?php // echo $form->field($model, 'comment_date') ?>

    <?php // echo $form->field($model, 'score') ?>

    <?php // echo $form->field($model, 'good_num') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
