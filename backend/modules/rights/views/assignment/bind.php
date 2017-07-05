<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\rights\models\Assignment */

$this->title = 'user-role bind';
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-create">

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'roles' => $roles,
    ]) ?>

</div>
