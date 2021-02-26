<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '审批业务';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approval-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建审批', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

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
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>
