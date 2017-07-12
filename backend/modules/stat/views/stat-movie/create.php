<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\stat\models\StatMovie */

$this->title = 'Create Stat Movie';
$this->params['breadcrumbs'][] = ['label' => 'Stat Movies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-movie-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
