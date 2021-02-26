<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model \backend\modules\feedback\models\Feedback */
/* @var $userDetails \backend\modules\feedback\models\UserDetails */

?>
<div class="box box-success direct-chat direct-chat-success">
    <?php $form = ActiveForm::begin([
        'action' => ['reply-submit'],
        'id' => 'form-save',

    ]); ?>

    <div class="box-body" id="feedback-box_body">
        <div id="dialog-box">
            <h4>审批状态</h4>
            <?php
            echo $form->field($model, 'status')->radioList($status_kv);
            echo $form->field($model, 'id')->hiddenInput()->label(false);
            ?>
            <h4>未通过答复</h4>

            <?php
//            echo \yii\helpers\Html::textarea('reply','',['rows' => 6 ,'style' => 'width:100%']);
            echo $form->field($model, 'reply')->textarea(['rows' => 6 ,'style' => 'width:100%']);
            ?>
        </div>
        <br/>
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-success','id'=>'feedback-input_btn']) ?>
        </div>

        <br/>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs(<<<JS
$(function(){ 
$(document).on('beforeSubmit', 'form#form-save', function () { 
    var form = $(this); 
    //返回错误的表单信息 
    if (form.find('.has-error').length) 
    { 
      return false; 
    } 
    //表单提交 
    $.ajax({ 
      url  : form.attr('action'), 
      type  : 'post', 
      data  : form.serialize(), 
      success: function (response){ 
       
          $("#modal-reply").modal('hide');
          $.pjax.reload({container:"#feedback-index", timeout:5000});         
       
      }, 
    }); 
    return false; 
  }); 
}); 
// $('#feedback-input_btn').on("click", function () {
//         var form = $(this); 
//         var input = $("#feedback-input_block");
//         var content = input.val();
//
//         if (content == '') {
//
//             return false;
//         }
//
//         $.ajax({
//             url: 'reply-submit',
//             type: 'post',
//             data: form.serialize(),
//             success: function(data){
//                 data = JSON.parse(data);
//                 if(data !== '1'){
//                     alert('修改失败！');
//                 }
//                 $.pjax.reload({container:"#feedback-index", timeout:5000});         
//            
//             }
//         });
//     });
JS
);

?>