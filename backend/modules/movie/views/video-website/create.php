<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\VideoWebsite */

$this->title = 'Create Video Website';
$this->params['breadcrumbs'][] = ['label' => 'Video Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-website-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
