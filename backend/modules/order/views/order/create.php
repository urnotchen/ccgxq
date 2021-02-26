<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = '新增预约项目';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">


    <?= $this->render('_form', [
        'position_kv' => $position_kv,
        'work_time_kv' => $work_time_kv,
        'model' => $model,
    ]) ?>

</div>
