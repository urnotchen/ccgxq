<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProjectCategory */

$this->title = '新建项目分类';
$this->params['breadcrumbs'][] = ['label' => 'Project Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-category-create">


    <?= $this->render('_form', [
        'category_kv' => $category_kv,
        'model' => $model,
    ]) ?>

</div>
