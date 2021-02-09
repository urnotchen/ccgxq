<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="book-form">

    <div class="form-group field-book-order_id required">

        <input type="hidden" id="book-order_id" class="form-control" name="Book[order_id]" value="2">

        <div class="help-block"></div>
    </div>
    <div class="form-group field-book-order_id required">
        <label class="control-label" for="book-order_id">预约项目</label>
        <input type="input" id="book-order_id" disabled ="true" class="form-control" name="Book[order_id]" value=<?= $order_name ?>

        <div class="help-block">
    </div>

    <div class="form-group field-book-order_id required">

        <input type="hidden" id="book-order_id" class="form-control" name="Book[order_id]" value="2">

        <div class="help-block"></div>
    </div>

    <div class="form-group field-book-order_id required">
        <label class="control-label" for="book-book-day_time">预约日期</label>

        <input type="input" id="book-book-day_time" disabled ="true" class="form-control" name="Book[order_id]" value=<?= $day_time ?>

        <div class="help-block">
    </div>
    <div class="alert alert-warning alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> 温馨提示</h4>
        预约人数已满，请返回上一级重新选择预约项目，如有问题请联系0452:22223333
    </div>

    <div style="text-align: center"><a href=<?php echo Yii::$app->request->referrer?>><button class="btn btn-default btn-lg">返回重新选择</button></a></div>
</div>