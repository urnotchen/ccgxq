<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\user\models\FilmChoiceUser;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\searches\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => '用户名',
                'format' => 'raw',
                'value' => function($model){
                    return $model->id;
                }
            ],
            'email:email',
            [
                'label' => '昵称',
                'format' => 'raw',
                'value' => function($model){
                    return $model->details->nickname;
                }
            ],
            [
                'attribute' => 'last_use_time',
                'label' => '最后使用时间',
                'format' => 'raw',
                'value' => function($model){
                    return Yii::$app->dateFormat->humanReadable3($model->last_use_time);
                }
            ],
            [
                'label' => '看过',
                'format' => 'raw',
                'value' => function($model){
                    return FilmChoiceUser::getUserChoiceNum(FilmChoiceUser::TYPE_SAW,$model->id);
                }
            ],
            [
                'label' => '短评数',
                'format' => 'raw',
                'value' => function($model){
                    return \backend\modules\user\models\FilmComment::getCommentNum($model->id);
                }
            ],
            [
                'label' => '可能喜欢',
                'format' => 'raw',
                'value' => function($model){
                    return \backend\modules\user\models\FilmComment::getCommentNum($model->id);
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => '注册时间',
                'format' => 'raw',
                'value' => function($model){
                    return Yii::$app->dateFormat->humanReadable3($model->created_at);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
