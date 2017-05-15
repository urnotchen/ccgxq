<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FilmVideoWebsite */

$this->title = 'Create Film Video Website';
$this->params['breadcrumbs'][] = ['label' => 'Film Video Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-video-website-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
