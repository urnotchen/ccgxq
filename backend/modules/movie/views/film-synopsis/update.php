<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmSynopsis */

$this->title = 'Update Film Synopsis: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Film Synopses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="film-synopsis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
