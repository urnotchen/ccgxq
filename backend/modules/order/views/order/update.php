<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = '修改预约项目: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-update">



    <?= $this->render('_form', [
        'position_kv' => $position_kv,
        'work_time_kv' => $work_time_kv,
        'model' => $model,
    ]) ?>

</div>
