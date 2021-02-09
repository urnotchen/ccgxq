<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '员工列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
     <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>
    <div class="pull-right margin">
        <?= Html::a('添加员工', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
       
    <?php echo $this->render('_search', ['model' => $searchModel, 'status_kv' => $status_kv, 'user_kv' => $user_kv,]);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'avatar',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img($model->avatar, ['style' => 'height:50px;width:50px']);
                },
                'options' => [
                    'style' => 'width:60px',
                ]
            ],

            [
                'attribute' => 'real_name',
                'format' => 'raw',
                'value' => function($model){
//                    return Html::tag('div',$model->real_name, ['style' => 'font-size:17px;color:gray']);
                    return $model->real_name;
                },
            ],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model) use ($status_kv){
                    if(strstr($model->username,'u_') && $model->pt_active == 0)
                        return '未激活';
                    return $status_kv[$model->status];
                },
            ],
            'updated_at:datetime',



            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {password}',
                'buttons' => [
                    'password' => function ($url, $model, $key) {
                        return Html::a('修改密码', $url);
                    },
                    ],
                ],
            ],
        ]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
</div>
