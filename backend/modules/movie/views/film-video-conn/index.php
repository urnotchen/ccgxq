<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\FilmVideoConnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Film Video Conns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-video-conn-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Film Video Conn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin()?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'movie_id',
                'website_id',
                'price',
                'type',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    <?php \bluelive\adminlte\widgets\BoxWidget::end()?>

</div>
