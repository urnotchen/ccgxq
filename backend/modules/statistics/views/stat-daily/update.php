<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\statistics\models\StatDaily */

$this->title = 'Update Stat Daily: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stat Dailies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stat-daily-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
