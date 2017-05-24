<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmRecommendOfficial */

$this->title = 'Update Film Recommend Official: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Film Recommend Officials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="film-recommend-official-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
