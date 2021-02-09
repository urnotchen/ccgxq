<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DayBook */

$this->title = 'Create Day Book';
$this->params['breadcrumbs'][] = ['label' => 'Day Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="day-book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
