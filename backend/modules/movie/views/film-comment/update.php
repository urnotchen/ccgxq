<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmComment */

$this->title = 'Update Film Comment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Film Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="film-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
