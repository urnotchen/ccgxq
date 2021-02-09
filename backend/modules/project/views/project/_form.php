<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_category_id')->widget(
        \kartik\select2\Select2::className(),
        [
            'data' => $category_kv,
            'language' => 'zh-CN',
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sxlx')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kbbm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sszt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'xscj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sdyj')->widget(\xj\ueditor\Ueditor::className(), [
        'style' => 'height:600px',
        'renderTag' => true,
        'readyEvent' => 'console.log("ready")',
        'jsOptions' => [
            'serverUrl' => yii\helpers\Url::to(['upload']),
            'autoHeightEnabled' => false,
            'autoFloatEnable' => true,
            'elementPathEnabled' => false,
            'toolbars' => [[
                'fullscreen', 'undo', 'redo', '|',
                'bold', 'italic', 'underline', '|', 'removeformat', 'formatmatch', 'blockquote', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                'customstyle', 'paragraph', 'fontsize', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                'link', 'unlink', '|',
                'simpleupload', 'insertimage', '|', 'insertvideo', 'music', 'attachment', 'drafts'
            ]],
            'wordCount' => false,
            'iframeCssUrl' => '/css/ueditor.css',
            'initialStyle' => 'p{line-height:1.6em;font-family:微软雅黑,Microsoft YaHei;font-size:16px}',
        ],
    ]) ?>

    <?= $form->field($model, 'qlly')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
