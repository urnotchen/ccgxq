<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use backend\modules\setting\models\AppVersion;


/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\setting\models\searches\AppVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户协议 ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-version-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>
    <?php Pjax::begin(['id' => 'app-version-index', 'timeout' => 5000])?>
    	<!--引入模态对话框 -->
    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>快捷修改</h2>',
        'id'=>'app_version_shortcut',
    ]);
    echo '<div id="app_version_shortcut_content"> </div>';

    \yii\bootstrap\Modal::end()
    ?>
        
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            [
                'attribute' => 'policy',
                'value' => function($model){

                    return json_decode($model->policy);
                },
            ],
            'version',
            'explain',
            [
                'class' => 'backend\modules\setting\widgets\AppVersionActionColumn',
            ],
        ],
    ]); ?>
        
<?php
$this->registerJs( <<<JS
    $.app_version_index();
JS
);
?>
    <?php Pjax::end()?>
    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>
</div>
