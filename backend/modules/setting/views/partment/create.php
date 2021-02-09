<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Partment */

$this->title = '添加部门';
$this->params['breadcrumbs'][] = ['label' => 'Partments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partment-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
