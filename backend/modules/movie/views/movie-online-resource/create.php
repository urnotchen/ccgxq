<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\movie\models\MovieOnlineResource */

$this->title = 'Create Movie Online Resource';
$this->params['breadcrumbs'][] = ['label' => 'Movie Online Resources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-online-resource-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
