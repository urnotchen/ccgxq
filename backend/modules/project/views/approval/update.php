<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Approval */

$this->title = 'Update Approval: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'project_kv' => $project_kv,
        'blclml' => $blclml,
        'model' => $model,
    ]) ?>

</div>
