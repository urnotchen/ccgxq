<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roles-index">

    <p>
        <?= Html::a('新增角色', ['role-create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
                'description',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $newUrl = ['view', 'name' => $model->name];
                            return Html::a('<i class="fa fa-eye"></i>', $newUrl);
                        },
                        'update' => function ($url, $model, $key) {
                            $newUrl = ['role-update', 'name' => $model->name];
                            return Html::a('<i class="fa fa-pencil"></i>', $newUrl);
                        },
                        'delete' => function ($url, $model, $key) {
                            $options = [
                                'title' => 'Delete',
                                'data-confirm' => '确定删除? 这会删除已有的与用户关联的记录',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];
                            $newUrl = ['role-delete', 'name' => $model->name];
                            return Html::a('<i class="fa fa-trash"></i>', $newUrl, $options);
                        },
                    ],
                ],
            ],
        ]); ?>

   <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>
