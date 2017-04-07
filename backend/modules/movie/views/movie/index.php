<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'MOVIE';

?>

<div class="row" id="movie-index">
    <div class="col-md-10">
        <?= \yii\helpers\Html::a('添加电影', ['create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px'])?>

        <?= $this->render('index_content', [
            'dataProvider' => $dataProvider
        ])?>
    </div>
</div>