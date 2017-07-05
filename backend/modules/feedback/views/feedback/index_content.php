<?php

use backend\modules\feedback\models\Feedback;

/* @var $dataProvider \yii\data\ActiveDataProvider */

?>

<?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label'=>'用户',
            'format'=>'raw',
            'value' => function(Feedback $model){

                return $this->render('index_user', [
                    'model' => $model
                ]);
            },
            'options' => ['class' => 'feedback-user']
        ],

//        [
//            'label'=>'反馈类型',
//            'format'=>'raw',
//            'value' => function(Feedback $model){
//
//                return Feedback::enum('type', $model->type);
//            },
//            'options' => ['class' => 'feedback-type']
//        ],

        [
            'label'=>'反馈内容',
            'format'=>'raw',
            'value' => function(Feedback $model){

                return $model->userFeedback->content;
            },
            'options' => ['class' => 'feedback-content']
        ],

        [
            'label'=>'状态',
            'format'=>'raw',
            'value' => function(Feedback $model){

                return Feedback::enum('status', $model->status);
            },
            'options' => ['class' => 'feedback-status']
        ],

        [
            'label'=>'app版本',
            'format'=>'raw',
            'value' => function(Feedback $model){

                return $model->app_v;
            },
            'options' => ['class' => 'feedback-app']
        ],

        [
            'label'=>'系统版本',
            'format'=>'raw',
            'value' => function(Feedback $model){

                return $model->os;
            },
            'options' => ['class' => 'feedback-os']
        ],

        [
            'label'=>'时间',
            'format'=>'raw',
            'value' => function(Feedback $model){

                $createdAt = Yii::$app->dateFormat->humanReadableDateTime($model->created_at);

                return <<<HTML

<div class="metadata-create">反馈时间：{$createdAt}</div>

HTML;
            },
            'options' => ['class' => 'feedback-time']
        ],

        [
            'label' => '操作',
            'format' => 'raw',
            'value' => function(Feedback $model){
                return <<<HTML

<button class="btn btn-read pull-left" fb_id="{$model->id}">已读</button>
<button class="btn btn-reply pull-right" fb_id="{$model->id}">回复</button>

HTML;
            },
            'options' => ['class' => 'feedback-operation']
        ],
    ]
])?>

<?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
