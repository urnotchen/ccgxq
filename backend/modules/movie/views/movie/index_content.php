<?php

use backend\modules\movie\models\Movie;

/* @var $dataProvider \yii\data\ActiveDataProvider */

?>

<?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label'=>'电影',
            'format'=>'raw',
            'value' => function(Movie $model){

                return $model->name_cn . "({$model->name_en})";
            },
            'options' => ['class' => 'movie-name']
        ],

        [
            'label'=>'海报',
            'format'=>'raw',
            'value' => function(Movie $model){

                return \yii\helpers\Html::img($model->poster, ['style' => 'height:200px;']);
            },
            'options' => ['class' => 'movie-poster']
        ],

        [
            'label'=>'导演',
            'format'=>'raw',
            'value' => function(Movie $model){

                return $model->director;
            },
            'options' => ['class' => 'movie-director']
        ],

        [
            'label'=>'演员',
            'format'=>'raw',
            'value' => function(Movie $model){

                return $model->actor;
            },
            'options' => ['class' => 'movie-actor']
        ],

        [
            'label'=>'评分/上映时间',
            'format'=>'raw',
            'value' => function(Movie $model){
                $time = Yii::$app->dateFormat->humanReadableDateTime($model->show_time);

                return <<<HTML
<div>豆瓣评分：{$model->grade_db}</div>
<div>上映时间：{$time}</div>
HTML;
            },
            'options' => ['class' => 'movie-grate-time']
        ],

        [
            'label'=>'操作',
            'format'=>'raw',
            'value' => function(Movie $model) {
                $viewOptions = array_merge([
                    'title' => '查看',
                    'aria-label' => '查看',
                    'data-pjax' => '0',
                ]);

                $deleteOptions = array_merge([
                    'title' => '删除',
                    'aria-label' => '删除',
                    'data-confirm' => '确定删除(将会删除所有用户相关信息)？',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]);

                $updateOptions = array_merge([
                    'title' => '修改',
                    'aria-label' => '修改',
                    'data-pjax' => '0',
                ]);

                $view   = \yii\helpers\Url::to(['view', 'id' => $model->id]);
                $update = \yii\helpers\Url::to(['update', 'id' => $model->id]);
                $delete = \yii\helpers\Url::to(['delete', 'id' => $model->id]);

                $btnView = \yii\helpers\Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    $view,
                    $viewOptions
                );
                $btnUpdate = \yii\helpers\Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    $update,
                    $updateOptions
                );
                $btnDelete = \yii\helpers\Html::a(
                    '<span class="glyphicon glyphicon-trash"></span>',
                    $delete,
                    $deleteOptions
                );

                return <<<HTML
$btnView&nbsp;&nbsp;&nbsp;$btnUpdate&nbsp;&nbsp;&nbsp;$btnDelete
HTML;

            },
            'options' => ['class' => 'movie-operation']
        ],
    ]
])?>

<?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
