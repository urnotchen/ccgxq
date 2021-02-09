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

    <h1><?= Html::encode($this->title) ?></h1>

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
            'project_id',
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
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
