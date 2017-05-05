<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\VideoConn */

$this->title = 'Update Video Conn: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Video Conns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="video-conn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
