<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Email */

$this->title = '邮件详情-'.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-view">


    <p>
        <?= Html::a('回复', ['reply', 'eid' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
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
            [
                'attribute' => 'created_at',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->humanReadable3($model->created_at);
                },
            ],
            [
                'attribute' => 'created_by',
                'value' => function($model) use ($user_kv){
                    return $user_kv[$model->created_by];
                },
            ], [
                'attribute' => 'sendto',
                'value' => function($model) use ($user_kv){
                    return $user_kv[$model->created_by];
                },
            ],
            'title',

            'content:html',




        ],
    ]) ?>

</div>
