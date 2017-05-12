<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Filmmaker */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Filmmakers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filmmaker-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'pic_id',
            'filmmaker_url:url',
            'name',
            'sex',
            'constellation',
            'birthday',
            'birthplace',
            'occupation',
            'more_foreign_name',
            'more_chinese_name',
            'family_member',
            'imdb',
            'imdb_title',
            'synopsis:ntext',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
