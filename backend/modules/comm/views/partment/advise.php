<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '意见列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partment-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>
    <?php Pjax::begin(['id' => 'app-version-index', 'timeout' => 5000])?>
    <!--引入模态对话框 -->
    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>快捷修改</h2>',
        'id'=>'app_version_shortcut',
    ]);
    echo '<div id="app_version_shortcut_content"> </div>';

    \yii\bootstrap\Modal::end()
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'partment',
                'label' => '部门',
                'format'=>'raw',
                'value' => function($model){
                    return '工商';

                },
            ],
            [
                'attribute' => 'advise',
                'label' => '建议/意见',
                'format'=>'raw',
                'value' => function($model){
                    return $model->advise;

                },
            ],
            [
                'attribute' => 'created_at',
                'label' => '提出时间',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->formatYMD($model->created_at);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end()?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>


</div>
