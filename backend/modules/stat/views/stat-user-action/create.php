<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\stat\models\StatUserAction */

$this->title = 'Create Stat User Action';
$this->params['breadcrumbs'][] = ['label' => 'Stat User Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-user-action-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
