<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FilmVideoConn */

$this->title = 'Create Film Video Conn';
$this->params['breadcrumbs'][] = ['label' => 'Film Video Conns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-video-conn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
