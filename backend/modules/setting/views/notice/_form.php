<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Notice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cate_id')->dropDownList($cate_kv) ?>

    <?= $form->field($model, 'content')->widget(\xj\ueditor\Ueditor::className(), [
        'style' => 'width:540px;height:600px',
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



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
