<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ConsultationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Consultation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'patient_name',
            'age',
            'sex',
            'disease_name',
            // 'illness:ntext',
            // 'need_consultation',
            // 'consultation_at',
            // 'consultation_people',
            // 'status',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
