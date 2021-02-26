<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
     <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

       
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'real_name',
                'format' => 'raw',
                'value' => function($model){
//                    return Html::tag('div',$model->real_name, ['style' => 'font-size:17px;color:gray']);
                    return $model->real_name;
                },
            ],
            'certificates_num',
            [
                'attribute' => 'real_name',
                'format' => 'raw',
                'value' => function($model){
//                    return Html::tag('div',$model->real_name, ['style' => 'font-size:17px;color:gray']);
                    return $model->real_name;
                },
            ],
            'username',
            'created_at:datetime',


            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {password}',
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
