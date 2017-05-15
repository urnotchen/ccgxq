<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmmakerRoleConn */

$this->title = 'Update Filmmaker Role Conn: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Filmmaker Role Conns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="filmmaker-role-conn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
