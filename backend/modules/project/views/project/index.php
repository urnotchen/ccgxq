<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建项目', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'project_category_id',
                'format'=>'raw',
                'value' => function($model){

                    return $model->category->name;
                },
            ],
            'name',
            'sxlx',
            'kbbm',
             'sszt',
            // 'xscj',
            // 'sdyj:ntext',
            // 'qlly',

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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
</div>
