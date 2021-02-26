<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\NoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>
    <p>
        <?= Html::a('添加文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [


            'id',
            'title',
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
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<?php \yii\widgets\Pjax::begin(['id' => 'notice_index', 'timeout' => 5000]); ?>


