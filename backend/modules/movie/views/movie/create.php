<?php

/* @var $this yii\web\View */
/* @var $model \backend\modules\movie\models\Movie */
/* @var $movieResource \backend\modules\movie\models\MovieResource */
/* @var $onlineResource \backend\modules\movie\models\OnlineResource */

$this->title = 'CREATE';

?>

<div class="movie-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>