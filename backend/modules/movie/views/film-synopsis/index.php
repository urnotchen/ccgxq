<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\helper\MovieHelper;
use backend\modules\movie\models\FilmSynopsis;
use bluelive\adminlte\widgets\BoxWidget;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\FilmSynopsisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '简介管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-synopsis-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php BoxWidget::begin();?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'movie_id',
                    'format' => 'raw',
                    'value' => function($model){
                        if($model->movie) {
                            return Html::a("<span class='lead'><strong>".MovieHelper::getChineseName($model->movie->title)."</strong></span>",
                                $model->movie->movie_url,
                                ['target' => '_blank']
                            );
                        }
                        return '';
                    },
                ],
                [
                    'attribute' => 'content',
                    'format' => 'raw',
                    'value' => function($model){
                        if($model->content) {
                            return "<span class='force_new_line'>" . str_replace('                                　　', '       ', str_replace("\n", '', $model->content . "</span>"));
                        }
                        return '';
                    },
                ],

                [
                    'attribute' => 'source',
                    'format' => 'raw',
                    'value' => function($model){
                        return FilmSynopsis::enum('source',$model->source);
                    },
                ],
                [
                    'attribute' => 'created_by',
                    'format' => 'raw',
                    'value' => function($model){
                        return FilmSynopsis::getSynopsisAuthor($model);
                    },
                ],
                [
                    'label' => '是否默认',
                    'format' => 'raw',
                    'value' => function($model){
                        if($model->source == FilmSynopsis::SOURCE_DOUBAN){
                            return '是';
                        }else{
                            return '否';
                        }
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php BoxWidget::end();?>
</div>
