<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '留言咨询';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">


    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'content:ntext',
            'reply:ntext',
            'telephone:ntext',
            [
                'attribute' => 'status',
                'format'=>'raw',
                'value' => function($model){

                    return $model::enum('status', $model->status);
                },
            ],
            [
                'attribute' => 'created_at',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->formatYMD($model->created_at);
                },
            ],
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
</div>
