<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FilmProperty */

$this->title = 'Create Film Property';
$this->params['breadcrumbs'][] = ['label' => 'Film Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-property-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
