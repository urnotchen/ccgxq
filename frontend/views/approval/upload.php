<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<br/>
<?php
echo $form->field($model, 'approval_id')->hiddenInput(['value' => $approval_id])->label(false);
echo $form->field($model, 'label_arr')->hiddenInput(['value' => $label_arr])->label(false);
    foreach ($tmp as $one){


        echo $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => '*'])->label($one);
    }

?>
    <div class="form-group">
        <?= Html::submitButton('上传', ['class' =>  'btn btn-success']) ?>
    </div>

<?php ActiveForm::end() ?>


