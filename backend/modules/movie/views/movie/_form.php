<?php

/* @var $model \backend\modules\movie\models\Movie */
/* @var $movieResource \backend\modules\movie\models\MovieResource */
/* @var $onlineResource \backend\modules\movie\models\OnlineResource */

//$model->show_time = $model->show_time ?
//    date('Y-m-d', $model->show_time) : null;

?>

<div class="staff-form">
    <?php

    \bluelive\adminlte\widgets\BoxWidget::begin();
    $form = \yii\widgets\ActiveForm::begin([
        'method' => 'post'
    ]);

    ?>

    <?= $form->field($model, 'movie_url')->textInput([
        'maxlength' => true,
        'placeholder' => '豆瓣链接'
    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'title')->textInput([
//        'maxlength' => true,
//        'placeholder' => '电影名'
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'title')->textInput([
//            'maxlength' => true,
//            'placeholder' => '电影名'
//    ]) ?>
<!---->
<!---->
<!--    --><?//= $form->field($model, 'director')->textInput([
//        'maxlength' => true,
////        'placeholder' => '豆瓣id'
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'screen_writer')->textInput([
//        'maxlength' => true,
//        'placeholder' => 'imdb id'
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'poster')->textInput([
//        'maxlength' => true,
//        'placeholder' => '海报链接'
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'director')->textarea([
//        'maxlength' => true,
//        'placeholder' => '逗号分隔'
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'actor')->textarea([
//        'maxlength' => true,
//        'placeholder' => '逗号分隔'
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'grade_db')->textInput([
//        'maxlength' => true,
//        'placeholder' => '豆瓣评分'
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'show_time')->widget(\kartik\date\DatePicker::className(), [
//        'options' => [
//            'class' => 'movie-show_time',
//            'style' => 'width: 300px;height: 33px;border: 1px solid #ccc !important;',
//            'placeholder' => '上映时间'
//        ],
//        'pluginOptions' => [
//            'format' => 'yyyy-mm-dd',
//            'todayHighlight' => true
//        ]
//    ]) ?>
<!---->
<!--    --><?//= $form->field($movieResource, 'bilibili')->textInput([
//        'maxlength' => true
//    ]) ?>
<!---->
<!--    --><?//= $form->field($movieResource, 'vqq')->textInput([
//        'maxlength' => true
//    ]) ?>
<!---->
<!--    <div class="row">-->
<!--        <div class="col-md-8">-->
<!--            --><?//= $form->field($onlineResource, 'url')->textInput([
//                'maxlength' => true
//            ]) ?>
<!--        </div>-->
<!--        <div class="col-md-2">-->
<!--            --><?//= $form->field($onlineResource, 'definition')->dropDownList(
//                \backend\modules\movie\models\OnlineResource::enum('definition'),
//                ['prompt'=>'请选择']
//            ) ?>
<!--        </div>-->
<!--    </div>-->

<!--    --><?//= $form->field($movieResource, 'iqiyi')->textInput([
//        'maxlength' => true
//    ]) ?>
<!---->
<!--    --><?//= $form->field($movieResource, 'youku')->textInput([
//        'maxlength' => true
//    ]) ?>
<!---->
<!--    --><?//= $form->field($movieResource, 'souhu')->textInput([
//        'maxlength' => true
//    ]) ?>
<!---->
<!--    --><?//= $form->field($movieResource, 'acfun')->textInput([
//        'maxlength' => true
//    ]) ?>

    <div class="form-group">
        <?= \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
</div>
