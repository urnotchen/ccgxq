<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FilmSynopsis */

$this->title = 'Create Film Synopsis';
$this->params['breadcrumbs'][] = ['label' => 'Film Synopses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-synopsis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
