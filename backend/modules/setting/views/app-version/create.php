<?php


/* @var $this yii\web\View */
/* @var $model \backend\modules\setting\models\AppVersion */

$this->title = '添加新版本';
$this->params['breadcrumbs'][] = ['label' => 'App版本', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-version-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
