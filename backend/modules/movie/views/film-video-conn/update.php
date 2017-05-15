<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmVideoConn */

$this->title = 'Update Film Video Conn: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Film Video Conns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="film-video-conn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
