<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\VideoWebsite */

$this->title = 'Update Video Website: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Video Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="video-website-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
