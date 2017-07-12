<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\movie\models\MovieOnlineResource */

$this->title = 'Update Movie Online Resource: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Movie Online Resources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="movie-online-resource-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
