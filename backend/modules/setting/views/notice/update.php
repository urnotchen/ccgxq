<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Notice */

$this->title = '修改公告: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="notice-update">


    <?= $this->render('_form', [
        'model' => $model,
        'cate_kv' => $cate_kv,
    ]) ?>

</div>
