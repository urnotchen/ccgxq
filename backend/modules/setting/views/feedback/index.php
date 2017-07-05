<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \backend\modules\feedback\models\searches\FeedbackSearch */

$this->title = '用户反馈';

\yii\widgets\Pjax::begin(['id' => 'feedback-index', 'timeout' => 5000]);

\yii\bootstrap\Modal::begin([
    'id' => 'modal-reply',
]);
echo '<div id="modal-content_reply" style="width: 100% !important"></div>';
\yii\bootstrap\Modal::end();

?>

<div class="row" id="metadata-index">
    <div class="col-md-10">
        <?= $this->render('index_search', [
            'model' => $searchModel
        ])?>

        <?= $this->render('index_content', [
            'dataProvider' => $dataProvider
        ])?>
    </div>
</div>

<?php

$this->registerJs(<<<JS

    $.feedback();

JS
);

\yii\widgets\Pjax::end();

?>