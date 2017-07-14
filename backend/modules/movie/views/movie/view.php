<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\Movie */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Movies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute' => 'movie_url','format' => ['url',['target' => '_blank']]],
            'pic_id',
            'title',
            'director',
            'screen_writer',
            'actor',
            'type',
            'producer_country',
            'language',
            'release_date',
            'alias',
            'imdb',
            'imdb_title',
            'official_website',
            'premiere',
            'release_year',
            'running_time',
            'comment_num',
            'score',
            'one_star',
            'two_star',
            'three_star',
            'four_star',
            'five_star',
            'episodes',
            'single_running_time',
            [
                'label' => '简介',
                'value' => function($model){
                    if(!$model->filmSynopsis){
                        return '';
                    }
                    return $model->filmSynopsis[0]->content;
                }
            ],
            ['label' => '标签','value' => implode(\backend\modules\movie\models\FilmTagConn::getMovieTag($model->id),',')],
            ['label' => '推荐','value' => implode(\backend\modules\movie\models\FilmRecommend::getRecommend($model->id),',')],
            ['label' => '在哪看','value' =>\backend\modules\movie\models\FilmVideoConn::getVideoLink($model->id),'format'=>'raw'],
        ],
    ]) ?>

</div>
