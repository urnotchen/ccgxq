<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PartmentSearchEmail */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Email', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [


            'id',
            'title',


            'status',
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

            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>
