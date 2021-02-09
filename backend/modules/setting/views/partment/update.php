<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Partment */

$this->title = '修改部门: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Partments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="partment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
