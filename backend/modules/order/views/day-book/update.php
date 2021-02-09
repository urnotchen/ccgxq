<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DayBook */

$this->title = 'Update Day Book: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Day Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="day-book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
