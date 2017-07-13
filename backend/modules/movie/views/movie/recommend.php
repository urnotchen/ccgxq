<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/7/13
 * Time: 10:17
 */



/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
use backend\modules\movie\widgets\MovieGridView;
$this->title = 'MOVIE';

?>

<div class="row" id="movie-index">

    <div class="col-md-12">
        <?php \yii\widgets\Pjax::begin(['id' => 'movie_index', 'timeout' => 5000]); ?>

        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= \yii\helpers\Html::a('添加电影', ['create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px'])?>

        <?php \bluelive\adminlte\widgets\BoxWidget::begin()?>

        <?php

            echo MovieGridView::widget([
                'stringColumns' => ['pic_id', 'title', 'director', 'actor', 'comment_num', 'score'],
                'dataProvider' => $dataProvider,
            ]);

        ?>

        <?php \bluelive\adminlte\widgets\BoxWidget::end()?>

    </div>
</div>


