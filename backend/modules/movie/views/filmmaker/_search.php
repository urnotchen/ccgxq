<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\search\FilmmakerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filmmaker-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pic_id') ?>

    <?= $form->field($model, 'filmmaker_url') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'constellation') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'birthplace') ?>

    <?php // echo $form->field($model, 'occupation') ?>

    <?php // echo $form->field($model, 'more_foreign_name') ?>

    <?php // echo $form->field($model, 'more_chinese_name') ?>

    <?php // echo $form->field($model, 'family_member') ?>

    <?php // echo $form->field($model, 'imdb') ?>

    <?php // echo $form->field($model, 'imdb_title') ?>

    <?php // echo $form->field($model, 'synopsis') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
