<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\VideoConn */

$this->title = 'Create Video Conn';
$this->params['breadcrumbs'][] = ['label' => 'Video Conns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-conn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
