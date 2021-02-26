<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Approval */

$this->title = '修改审批业务: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="approval-update">


    <?= $this->render('_form', [
        'project_kv' => $project_kv,
        'blclml' => $blclml,
        'model' => $model,
    ]) ?>

</div>
