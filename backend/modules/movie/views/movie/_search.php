<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\movie\models\MovieOnlineResource;
use backend\modules\movie\models\FilmType;
use kartik\select2\Select2;
?>

<div class="movie-search ">


    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',
        ],
        'fieldClass' => '\bluelive\adminlte\widgets\ActiveField',
    ]); ?>
    <?= $form->field($model, 'film_type')->widget(Select2::classname(), [
        'data' => FilmType::getTypeList(),
        'language' => 'zh-CN',
        'options' => ['placeholder' => '类型筛选'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'definition')->dropDownList(MovieOnlineResource::enum('definition'),['prompt' => '资源清晰度']) ?>

    <?= $form->field($model, 'all_title')->textInput([
        'maxlength' => true,
        'placeholder' => '标题关键字 '
    ]) ?>
    <?= $form->field($model, 'actor')->textInput([
        'maxlength' => true,
        'placeholder' => '演员 '
    ]) ?>



<!--    --><?php // echo $form->field($model, 'actor') ?>

    <?php  echo $form->field($model, 'film_property')->hiddenInput() ?>

<!--    --><?php // echo $form->field($model, 'release_year')->dropDownList(range(1900,date("Y"))) ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
