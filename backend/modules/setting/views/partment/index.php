<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '部门列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partment-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <p>
        <?= Html::a('添加部门', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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

            'id',
            'partname',
            'info',
            'status',
            'created_at:datetime',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end()?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>


</div>
