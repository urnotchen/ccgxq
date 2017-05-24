<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\movie\widgets\MovieGridView;

$this->title = '官方电影推荐表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-recommend-official-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php

        echo MovieGridView::widget([
        'stringColumns' => ['order','pic_id', 'title', 'director', 'actor', 'comment_num', 'score','sequence'],
        'dataProvider' => $dataProvider,
        'property' => Yii::$app->request->queryParams['MovieSearch']['film_property'],
        ]);

    ?>
</div>
