<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FilmmakerRoleConn */

$this->title = 'Create Filmmaker Role Conn';
$this->params['breadcrumbs'][] = ['label' => 'Filmmaker Role Conns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filmmaker-role-conn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
