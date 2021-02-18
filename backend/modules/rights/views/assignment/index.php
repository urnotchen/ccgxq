<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-index">

    <p>
        <?= Html::a('绑定', ['bind'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [

                [
                    'attribute' => 'username',
                    'label' => '用户',
                ],

                [
                    'attribute' => '角色',
                    'value' => function ($model) {
                        return implode('，', $model['roles']);
                    },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {revoke-all}',
                    'buttons' => [
                        'update' => function ($url, $model, $index) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                ['bind', 'user_id' => $model['user_id']]
                            );
                        },
                        'revoke-all' => function ($url, $model, $index) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                ['revoke-all', 'user_id' => $model['user_id']],
                                [
                                    'data-confirm' => '确定解绑?',
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                    ],
                ],
            ],
        ]); ?>

   <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>
