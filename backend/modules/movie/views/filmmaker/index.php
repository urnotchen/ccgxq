<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\FilmmakerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Filmmakers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filmmaker-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Filmmaker', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'pic_id',
            'filmmaker_url:url',
            'name',
            'sex',
            // 'constellation',
            // 'birthday',
            // 'birthplace',
            // 'occupation',
            // 'more_foreign_name',
            // 'more_chinese_name',
            // 'family_member',
            // 'imdb',
            // 'imdb_title',
            // 'synopsis:ntext',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
