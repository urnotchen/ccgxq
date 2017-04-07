<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\movie\models\Movie */

$this->title = $model->name_cn;

?>
<div class="movie-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary'
        ]) ?>
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
            'name_cn',
            'name_en',
            'poster',
            'director',
            'actor:ntext',
            'grade_db',
            'show_time:datetime'
        ],
    ]) ?>

    <?= DetailView::widget([
        'model' => $model->movieResource,
        'attributes' => [
            'bilibili',
            'vqq',
            'iqiyi',
            'youku',
            'souhu',
            'acfun'
        ],
    ]) ?>

    <?= DetailView::widget([
        'model' => $model->onlineResource,
        'attributes' => [
            'url',
            [
                'attribute' => 'definition',
                'value' => function ($model, $widget) {
                    if (empty($model->definition)) {
                        return '';
                    }

                    return \backend\modules\movie\models\OnlineResource::enum('definition', $model->definition);
                }
            ],
        ],
    ]) ?>

</div>