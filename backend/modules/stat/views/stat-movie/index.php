<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\stat\models\searches\StatMovieSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电影统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-movie-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin()?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'day',
                    'format' => 'raw',
                    'value' => function($model){
                        return Yii::$app->dateFormat->humanReadableDate($model->day);
                    }
                ],
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
                'num',
                [
                    'attribute' => 'type',
                    'format' => 'raw',
                    'value' => function($model){
                        return $model->enum('type')[$model->type];
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end() ?>
</div>
