<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\stat\models\StatMovie */

$this->title = 'Update Stat Movie: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stat Movies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stat-movie-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
