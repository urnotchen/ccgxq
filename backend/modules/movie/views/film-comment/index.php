<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\movie\models\Movie;
use backend\modules\movie\models\FilmComment;
use backend\modules\movie\widgets\FilmCommentGridView;

if(isset(Yii::$app->request->queryParams['FilmCommentSearch']['movie_id'])) {
    $this->title = Movie::findOneOrException(['id' => Yii::$app->request->queryParams['FilmCommentSearch']['movie_id']])->title . '-短评';
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="film-comment-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Film Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
        FilmCommentGridView::widget([
            'stringColumns' => null,
            'dataProvider'  => $dataProvider,
            'stringColumns' => 'pic_id,comment_date,star,good_num,comment'
        ])
    ?>

</div>
