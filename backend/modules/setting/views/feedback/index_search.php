<?php

use yii\web\JsExpression;
use kartik\daterange\DateRangePicker;

use backend\modules\setting\models\UserDetails;

/* @var $model \backend\modules\feedback\models\searches\FeedbackSearch */

$createdBy = intval($model->created_by) ?
    [$model->created_by => UserDetails::findOneOrException(['user_id' => $model->created_by])->nickname] :
    [];

?>

<div class="row">
    <div class="col-md-8">
        <?php $form = \yii\widgets\ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'class' => 'form-inline',
            ],
            'fieldClass' => '\bluelive\adminlte\widgets\ActiveField',
        ]); ?>

        <?= $form->field($model, 'created_by')->widget(\kartik\select2\Select2::className(), [
            'data' => $createdBy,
            'options' => ['placeholder' => '用户...'],
            'pluginOptions' => [
                'placeholder' => 'search ...',
                'allowClear' => true,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting...'; }"),
                ],
                'ajax' => [
                    'url' => 'search-user',
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {from:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
                'width' => '200px',
            ],
        ])?>

        <?= $form->field($model, 'created_at')->label(false)->widget(DateRangePicker::className(), [
                'options' => [
                    'class' => 'feedback-data_range',
                    'style' => 'width: 300px;height: 33px;border: 1px solid #ccc !important;',
                    'placeholder' => '反馈时间'
                ],
            ]
        ); ?>

        <div class="form-group">
            <?= \yii\helpers\Html::submitButton('筛选', ['class' => 'btn btn-primary']) ?>
            <div class="help-block"></div>
        </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
</div>
