<?php

/* @var $this yii\web\View */
/* @var $model \backend\modules\setting\models\Misc */

$this->title = '用户协议';

?>

<div class="staff-create row">
    <div class="col-md-7">
        <?php
        \bluelive\adminlte\widgets\BoxWidget::begin();

        if (! $model->isNewRecord) {
            echo \yii\helpers\Html::a(
                'Update',
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary pull-right']
            );

            echo $model->policy;
        }

        \bluelive\adminlte\widgets\BoxWidget::end();
        ?>
    </div>
</div>
