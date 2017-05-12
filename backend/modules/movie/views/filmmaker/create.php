<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Filmmaker */

$this->title = 'Create Filmmaker';
$this->params['breadcrumbs'][] = ['label' => 'Filmmakers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filmmaker-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
