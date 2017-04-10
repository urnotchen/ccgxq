<?php

/* @var $this yii\web\View */
/* @var $model \backend\modules\setting\models\Misc */

$this->title = '用户协议';

?>

<div class="staff-create row">
    <div class="col-md-7">
        <?php

        \bluelive\adminlte\widgets\BoxWidget::begin();
        $form = \yii\widgets\ActiveForm::begin([
            'method' => 'post'
        ]);

        ?>

        <?= $form->field($model, 'policy')->widget(\xj\ueditor\Ueditor::className(), [
            'style' => 'width:800px;height:600px',
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
        ])->label("内容") ?>

        <div class="form-group">
            <?= \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php \yii\widgets\ActiveForm::end(); ?>

        <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
    </div>
</div>
