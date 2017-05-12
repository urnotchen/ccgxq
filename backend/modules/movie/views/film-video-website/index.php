<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\FilmVideoWebsiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Film Video Websites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-video-website-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Film Video Website', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'sub_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
