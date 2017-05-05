<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\VideoWebsiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Video Websites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-website-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Video Website', ['create'], ['class' => 'btn btn-success']) ?>
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
