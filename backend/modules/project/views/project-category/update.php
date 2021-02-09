<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectCategory */

$this->title = '修改项目分类: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Project Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-category-update">


    <?= $this->render('_form', [
        'category_kv' => $category_kv,
        'model' => $model,
    ]) ?>

</div>
