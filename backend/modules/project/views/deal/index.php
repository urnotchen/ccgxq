<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\search\DealSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户在线办理';
$this->params['breadcrumbs'][] = $this->title;




\yii\bootstrap\Modal::begin([
    'id' => 'modal-reply',
    'header' => '<h2>审批</h2>',
    'size'=>'modal-sm',
]);
echo '<div id="modal-content_reply"></div>';
\yii\bootstrap\Modal::end();

?>
<div class="deal-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>
    <?php \yii\widgets\Pjax::begin(['id' => 'feedback-index', 'timeout' => 5000]);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'approval_id',
                'format'=>'raw',
                'value' => function($model){

                    return $model->approval->name;
                },
            ],
            [
                'attribute' => 'file_arr',
                'format'=>'raw',
                'value' => function($model){
                    $str = '';
                    $model->file_arr = unserialize($model->file_arr);
                    foreach ($model->file_arr as $file){
                        $str .= Html::a('文件下载',APP_DOMAIN_SCHEMA.APP_FRONT_BASE_DOMAIN.'/'.$file).'<br/>';
                    }
                    return $str;
                },
            ],
            [
                'attribute' => 'reply',
                'format'=>'raw',
                'value' => function($model){
                    return $model->reply?$model->reply:'未回复';

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
            [
                'label' => '操作',
                'format' => 'raw',
                'value' => function($model){
                    return <<<HTML

<button class="btn btn-reply pull-left" id="{$model->id}">审批</button>
<button class="btn  pull-right"><a href="/peoject/deal/delete?id={$model->id}" style="color:black" data-confirm="您确定要删除此项吗？">删除</a></button>


HTML;
                },
                'options' => ['class' => 'feedback-operation']
            ],
        ],
    ]); ?>

<?php
$this->registerJs( <<<JS

    $(".btn-reply").on("click", function(){
        var id = this.getAttribute('id');

        $("#modal-content_reply").load("reply?id=" +id);
        $("#modal-reply").modal({
        });
        return false;
    });

    $(".btn-read").on("click", function(){
        var id = this.getAttribute('fb_id');

        $.ajax({
            url: "read",
            type: 'get',
            data: {
                id: id
            },
            success: function(data){
                console.log(data);
                $.pjax.reload({container: "#feedback-index",timeout: 5000});
            }
        });
    });

    $("#modal-reply").on("hidden.bs.modal", function() {
        $.pjax.reload({container:"#feedback-index",timeout: 5000});
    });

JS
);

?>
    <?php \yii\widgets\Pjax::end(); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>