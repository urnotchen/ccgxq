<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-category-index">



    <p>
        <?= Html::a('添加项目分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name',
            [
                'attribute' => 'category_id',
                'format'=>'raw',
                'value' => function($model){
                    return $model::enum('category', $model->category_id);

                },
            ],
            [
                'attribute' => 'status',
                'format'=>'raw',
                'value' => function($model){
                    return $model::enum('status', $model->status);

                },
            ],
            [
                'attribute' => 'created_at',
                'format'=>'raw',
                'value' => function($model){

                    return \Yii::$app->timeFormatter->humanReadable3($model->created_at);
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
