<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approvals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approval-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Approval', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'project_id',
            'name',
            'sequence',
            'agency',
            // 'basic_sxlx',
            // 'basic_bjlx',
            // 'basic_sszt',
            // 'basic_xscj',
            // 'basic_cnbjsx',
            // 'basic_fdbjsx',
            // 'basic_is_charge',
            // 'basic_dbsxccs',
            // 'basic_zxfs',
            // 'basic_jdtsfs',
            // 'basic_blsj',
            // 'basic_bldd',
            // 'process',
            // 'blclml:ntext',
            // 'sltj:ntext',
            // 'sfbz',
            // 'sdyj:ntext',
            // 'question:ntext',
            // 'is_online',
            // 'status',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
