<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\FilmVideoConnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电影在线观看管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-video-conn-index">

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
                        return Html::a(\backend\helper\MovieHelper::getChineseName($model->movie->title),$model->movie->movie_url,['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'website_id',
                    'format' => 'raw',
                    'value' => function($model){
                        if(!$model->website){
                            return '';
                        }
                        return Html::a($model->website->name,$model->url,['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'price',
                    'format' => 'raw',
                    'value' => function($model){
                        return $model->price;
                    }
                ],
                [
                    'attribute' => 'type',
                    'format' => 'raw',
                    'value' => function($model){
                        return $model->enum('type')[$model->type];
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'raw',
                    'value' => function($model){
                        return Yii::$app->dateFormat->humanReadable3($model->created_at);
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    <?php \bluelive\adminlte\widgets\BoxWidget::end()?>

</div>
