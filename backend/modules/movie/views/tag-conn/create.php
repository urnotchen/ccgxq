<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\movie\models\TagConn */

$this->title = 'Create Tag Conn';
$this->params['breadcrumbs'][] = ['label' => 'Tag Conns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-conn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
