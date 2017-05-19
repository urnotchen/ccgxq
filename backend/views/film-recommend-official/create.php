<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FilmRecommendOfficial */

$this->title = 'Create Film Recommend Official';
$this->params['breadcrumbs'][] = ['label' => 'Film Recommend Officials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-recommend-official-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
