<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评价分数';
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

            'partname',
            [
                'attribute' => 'grade',
                'label' => '综合评分',
                'format'=>'raw',
                'value' => function($model){
                    return round($model->grade,1).'分';

                },
            ],
            [
                'attribute' => 'grade',
                'label' => '评分人数',
                'format'=>'raw',
                'value' => function($model){
                    return $model->num.'人';

                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end()?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>


</div>
