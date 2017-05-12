<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\FilmmakerRoleConnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Filmmaker Role Conns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filmmaker-role-conn-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Filmmaker Role Conn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'movie_id',
            'filmmaker_id',
            'role_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
