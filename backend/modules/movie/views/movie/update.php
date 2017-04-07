<?php

/* @var $this yii\web\View */
/* @var $model \backend\modules\movie\models\Movie */
/* @var $movieResource \backend\modules\movie\models\MovieResource */
/* @var $onlineResource \backend\modules\movie\models\OnlineResource */

$this->title = $model->name_cn;

?>

<div class="movie-update">

    <?= $this->render('_form', [
        'model' => $model,
        'movieResource' => $movieResource,
        'onlineResource' => $onlineResource
    ]) ?>

</div>