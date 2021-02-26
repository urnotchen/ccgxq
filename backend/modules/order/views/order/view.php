<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">


    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'id',
            [
                'attribute' => 'position_id',
                'format'=>'raw',
                'value' => function($model){
                    return $model::enum('position', $model->position_id);

                },
            ],
            'name',
            'img:image',
            'content:html',
            'map',
            'times',
            [
                'attribute' => 'created_at',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->formatYMD($model->created_at);
                },
            ],
            [
                'attribute' => 'created_by',
                'format'=>'raw',
                'value' => function($model) use ($user_kv){

                    return $model->created_by?$user_kv[$model->created_by]:'';
                },
            ],
            [
                'attribute' => 'updated_at',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->formatYMD($model->updated_at);
                },
            ],
            [
                'attribute' => 'updated_by',
                'format'=>'raw',
                'value' => function($model) use ($user_kv){

                    return $model->updated_by?$user_kv[$model->updated_by]:'';
                },
            ],
        ],
    ]) ?>

</div>
