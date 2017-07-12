<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\movie\models\search\MovieOnlineResourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电影网络资源管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-online-resource-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin()?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'movie_id',
                'format' => 'raw',
                'value' => function($model){
                    if(!$model->movie){
                        return '';
                    }
                    return Html::a(($model->movie->title),$model->movie->movie_url,['target' => '_blank']);
                }
            ],
            [
                'attribute' => 'definition',
                'format' => 'raw',
                'value' => function($model){
                    if(!$model->definition){
                        return '';
                    }
                    return $model->enum('definition')[$model->definition];
                }
            ],
            'created_at',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php \bluelive\adminlte\widgets\BoxWidget::end()?>

</div>
