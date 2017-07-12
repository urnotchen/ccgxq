<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\stat\models\StatUserAction */

$this->title = 'Update Stat User Action: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stat User Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stat-user-action-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
