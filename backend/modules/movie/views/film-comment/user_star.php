<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\movie\models\Movie;
use backend\modules\movie\models\FilmComment;
use backend\modules\movie\widgets\FilmCommentGridView;
use bluelive\adminlte\widgets\BoxWidget;
if(isset(Yii::$app->request->queryParams['FilmCommentSearch']['movie_id'])) {
    $this->title = Movie::findOneOrException(['id' => Yii::$app->request->queryParams['FilmCommentSearch']['movie_id']])->title . '-短评';
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="film-comment-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php BoxWidget::begin();?>
        <?=
            FilmCommentGridView::widget([
                'stringColumns' => null,
                'dataProvider'  => $dataProvider,
                'stringColumns' => 'username,movie_name,star,comment,good_num,created_at'
            ]);
        ?>
    <?php BoxWidget::end();?>
</div>
