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
    ])->label('豆瓣链接')?>

    <div class="form-group">
        <?= \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
</div>
