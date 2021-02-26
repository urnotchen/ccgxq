<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\rights\models\Item */

$this->title = '新增角色';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['roles']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <?= $this->render('_form-role', [
        'model' => $model,
    ]) ?>

</div>
