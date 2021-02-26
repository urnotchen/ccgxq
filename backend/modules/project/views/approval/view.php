<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Approval */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approval-view">


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
                'attribute' => 'project_id',
                'format'=>'raw',
                'value' => function($model){

                    return $model->project->name;
                },
            ],
            'name',
            'sequence',
            'agency',
            'basic_sxlx',
            'basic_bjlx',
            'basic_sszt',
            'basic_xscj',
            'basic_cnbjsx',
            'basic_fdbjsx',
            'basic_is_charge',
            'basic_dbsxccs',
            'basic_zxfs',
            'basic_jdtsfs',
            'basic_blsj',
            'basic_bldd',
            'process',
            'blclml:ntext',
            'sltj:ntext',
            'sfbz',
            'sdyj:ntext',
            'question:ntext',
            'is_online',
            'status',
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

                    return $user_kv[$model->created_by];
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

                    return $user_kv[$model->updated_by];
                },
            ],
        ],
    ]) ?>

</div>
