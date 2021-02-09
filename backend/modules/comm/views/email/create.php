<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Email */

$this->title = 'Create Email';
$this->params['breadcrumbs'][] = ['label' => 'Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-create">


    <?= $this->render('_form', [
        'model' => $model,
        'user_kv' => $user_kv,
    ]) ?>

</div>
