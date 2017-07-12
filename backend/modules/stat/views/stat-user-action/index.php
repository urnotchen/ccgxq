<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\stat\models\searches\StatUserActionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电影斩标记统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-user-action-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php \bluelive\adminlte\widgets\BoxWidget::begin() ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'day',
                    'format' => 'raw',
                    'value' => function($model){
                        return Yii::$app->dateFormat->humanReadableDate($model->day);
                    }
                ],
                'count',
//                'type',
                [
                    'attribute' => 'sub_type',
                    'format'=> 'raw',
                    'value' => function($model){
                        if(!$model->sub_type){
                            return '';
                        }
                        return $model->enum('sub_type')[$model->sub_type];
                    }
                ],
        // 'daily:ntext',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end()?>
</div>
