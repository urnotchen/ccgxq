<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\statistics\models\StatDaily */

$this->title = 'Create Stat Daily';
$this->params['breadcrumbs'][] = ['label' => 'Stat Dailies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-daily-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
