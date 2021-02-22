<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Selection */

$this->title = '我要评价';
$this->params['breadcrumbs'][] = ['label' => 'Selections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selection-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'department' => $department,
        'grade' => $grade,
    ]) ?>

</div>
