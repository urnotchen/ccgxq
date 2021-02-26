<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Approval */

$this->title = '添加审批业务';
$this->params['breadcrumbs'][] = ['label' => 'Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approval-create">

    <?= $this->render('_form', [
        'blclml' => $blclml,
        'project_kv' => $project_kv,
        'model' => $model,
    ]) ?>

</div>
