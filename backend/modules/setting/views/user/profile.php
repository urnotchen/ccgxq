<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'username',
            'email:email',
            'avatar:url',
            'real_name',
            'qq',
            'alipay',

            'created_at:datetime',
            'updated_at:datetime',
            'updatedBy.username',
        ],
    ]) ?>

</div>
