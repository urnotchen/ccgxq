<?php

/* @var $content string */

?>
<div class="content-wrapper">
    <section class="content-header">

        <h1>
            <?= $this->title; ?>
        </h1>

        <?= \yii\widgets\Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </section>

    <section class="content">
        <?= \dmstr\widgets\Alert::widget(); ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>©雪光信息技术有限公司提供技术支持</strong>
</footer>
