<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\user\models\FilmChoiceUser;
use backend\modules\user\models\FilmComment;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\searches\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin()?>
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
                    'label' => '看过',
                    'format' => 'raw',
                    'value' => function($model){
                        return FilmChoiceUser::getUserChoiceNum(FilmChoiceUser::TYPE_SAW,$model->id);
                    }
                ],
                [
                    'label' => '想看',
                    'format' => 'raw',
                    'value' => function($model){
                        return FilmChoiceUser::getUserChoiceNum(FilmChoiceUser::TYPE_WANT,$model->id);
                    }
                ],
                [
                    'label' => '短评数',
                    'format' => 'raw',
                    'value' => function($model){
                        $num = FilmComment::getCommentNum($model->id);
                        if($num == 0){
                            return $num;
                        }
                        $type = FilmComment::TYPE_USER;
                        $userId = $model->id;
                        return HTML::a($num
                            ,"/movie/film-comment/user-index?FilmCommentSearch[type]={$type}&FilmCommentSearch[user_id]={$userId}&FilmCommentSearch[exist_content] = 1"
                            ,['target' => '_blank']);
                    }
                ],
                [
                    'label' => '可能喜欢',
                    'format' => 'raw',
                    'value' => function($model){
                        return Html::a('点击查看',
                            "/movie/movie/recommend?MovieSearch[user_id]={$model->id}",
                            ['target' => '_blank']
                        );
                    }
                ],
                [
                    'attribute' => 'last_use_time',
                    'label' => '最后操作时间',
                    'format' => 'raw',
                    'value' => function($model){
                        return Yii::$app->dateFormat->humanReadable3($model->last_use_time);
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
    <?php \bluelive\adminlte\widgets\BoxWidget::end()?>
</div>
