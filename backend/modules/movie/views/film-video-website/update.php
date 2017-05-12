<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmVideoWebsite */

$this->title = 'Update Film Video Website: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Film Video Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="film-video-website-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
