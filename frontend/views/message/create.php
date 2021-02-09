<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no,maximum-scale=1.0, minimum-scale=1.0">
    <title>咨询</title>
    <link rel="stylesheet" href="https://www.cqgxqzwzx.com/assets/css/mui.min.css">
    <link rel="stylesheet" href="https://www.cqgxqzwzx.com/assets/css/global.css">
    <link rel="stylesheet" href="https://www.cqgxqzwzx.com/assets/fonts/myIcon/iconfont.css">
    <link rel="stylesheet" href="https://www.cqgxqzwzx.com/assets/css/tszx/tszx.css">
</head>

<body class="mui-ios mui-ios-11 mui-ios-11-0">
<div id="app"><div class="page bar-tab">
        <div class="content">
            <div class="banner banner-complaints">
                <div class="container-fluid">
                    我要咨询受理范围：对进驻政务服务中心的业务进行有关注册、办事程序、办理条件等封面的具体咨询。
                </div>
            </div>
            <?php $form = ActiveForm::begin(); ?>
            <div class="message-form">
                <?php $form = ActiveForm::begin(); ?>
            <div class="container-fluid tszx-form">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">姓名</span>
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => '请输入姓名'])->label(false) ?>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">手机号</span>
                        <?= $form->field($model, 'telephone')->textInput(['placeholder' => '请输入手机号'])->label(false) ?>

                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">标题</span>
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder' => '请输入标题'])->label(false) ?>

                    </div>
                    <div class="input-group textarea">
                        <span class="input-group-addon">内容</span>
                        <?= $form->field($model, 'content')->textarea(['rows' => 6,'placeholder' => '请输入咨询内容'])->label(false)?>
<!--                        <p><span>0</span>/300</p>-->
                    </div>
                    <div class="input-group">

                            <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-block submit-btn','data-loading-text' => '提交中']) ?>

                    </div>
                </div>
                <a href="zxzx_BusinessList.html?mintype=ts" class="operation text-primary">我的咨询</a>
            </div>
                <?php ActiveForm::end(); ?>

            </div>
    </div>

        <?= $this->render('/layouts/bottom') ?>
</div>


</body></html>