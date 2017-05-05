<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\VideoConnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Video Conns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-conn-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Video Conn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'movie_id',
            'website_id',
            'price',
            'type',
            // 'url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
