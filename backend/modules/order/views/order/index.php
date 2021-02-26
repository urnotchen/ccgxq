<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '预约项目';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建预约项目', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'position_id',
                'format'=>'raw',
                'value' => function($model){
                    return $model::enum('position', $model->position_id);

                },
            ],
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
</div>
