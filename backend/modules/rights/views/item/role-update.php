<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\rights\models\Item */

$this->title = 'Update Item: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['roles']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-update">

    <?= $this->render('_form-role', [
        'model' => $model,
    ]) ?>

</div>
