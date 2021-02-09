<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Notice */

$this->title = '添加公告';
$this->params['breadcrumbs'][] = ['label' => 'Notices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-create">


    <?= $this->render('_form', [
        'model' => $model,
        'cate_kv' => $cate_kv,
    ]) ?>

</div>
