<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Partment */

$this->title = '修改部门: ' . $model->partname;
$this->params['breadcrumbs'][] = ['label' => 'Partments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="partment-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
