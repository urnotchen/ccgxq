<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\FilmRecommendOfficialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Film Recommend Officials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-recommend-official-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Film Recommend Official', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'movie_id',
            'created_at',
            'created_by',
            'updated_at',
            // 'updated_by',
            // 'sequence',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
