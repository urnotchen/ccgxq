<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
use backend\modules\movie\widgets\MovieGridView;
$this->title = 'MOVIE';

?>

<div class="row" id="movie-index" style="max-width: 1200px;">

    <div class="col-md-12" >
        <?php \yii\widgets\Pjax::begin(['id' => 'movie_index', 'timeout' => 5000]); ?>

        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php \bluelive\adminlte\widgets\BoxWidget::begin()?>

            <?php
                if(isset(Yii::$app->request->queryParams['MovieSearch']['film_property']) && !empty(Yii::$app->request->queryParams['MovieSearch']['film_property'])) {
                    echo MovieGridView::widget([
                        'stringColumns' => ['order','movieArea', 'score','comment_num','resource','sequence'],
                        'dataProvider' => $dataProvider,
                        'property' => Yii::$app->request->queryParams['MovieSearch']['film_property'],
                    ]);
                }else{
                   echo MovieGridView::widget([
                        'stringColumns' => ['movieArea', 'score','comment_num','resource'],
                        'dataProvider' => $dataProvider,
                    ]);
                }
            ?>

        <?php \bluelive\adminlte\widgets\BoxWidget::end()?>

    </div>
</div>

<?php
    $this->registerJs(<<<JS
        $('.setProperty').on('click',setProperty);
        $('.motion').on('click',setSequence);
JS
);

?>
<?php \yii\widgets\Pjax::end() ?>
