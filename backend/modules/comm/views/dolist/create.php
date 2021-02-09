<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Dolist */

$this->title = 'Create Dolist';
$this->params['breadcrumbs'][] = ['label' => 'Dolists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dolist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
