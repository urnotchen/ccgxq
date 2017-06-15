<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\movie\models\FilmmakerRoleConn;
use bluelive\adminlte\widgets\BoxWidget;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\movie\models\search\FilmmakerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Filmmakers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filmmaker-index">


    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php BoxWidget::begin()?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [

                'pic_id' => [
                    'format'=>'raw',
                    'value' => function($model){
                        return Html::a(
                                \yii\helpers\Html::img(Yii::$app->params['qiniuDomain'].str_replace('pictures','',$model->image->path), ['class' => 'filmmaker_img']),
                                $model->filmmaker_url,
                                ['target' => '_blank','width' => '10px','height' => '220px']);
                    },
                ],
                'name' => [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function($model){
                        $titleList = explode(' ',$model->name,2);
                        return $titleList?$titleList[0]:'';
                    }
                ],
                'local_name' => [
                    'label' => '英文姓名',
                    'format' => 'raw',
                    'value' => function($model){
                        $titleList = explode(' ',$model->name,2);
                        $alias = count($titleList) == 2 ? $titleList[1] : '';
                        return $alias;
                    },
                ],
//                'sex',
                // 'constellation',
                // 'birthplace',
                'occupation',
                'birthday',
                'work_num' => [
                    'label' => '作品数量',
                    'format' => 'raw',
                    'value' => function($model){
                        return Html::a(count(FilmmakerRoleConn::getFilmmakerWorkNum($model->id)),
                            "/movie/movie/index?MovieSearch%5Bfilmmaker_id%5D={$model->id}",
                            ['target' => '_blank']);
                    }
                ],
                // 'more_foreign_name',
                // 'more_chinese_name',
                // 'family_member',
                // 'imdb',
                // 'imdb_title',
                // 'synopsis:ntext',
                // 'created_at',
                // 'created_by',
                // 'updated_at',
                // 'updated_by',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php BoxWidget::end();?>
</div>
