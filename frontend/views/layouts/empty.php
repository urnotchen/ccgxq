<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

if ( in_array(Yii::$app->controller->action->id, ['login', 'error']) && Yii::$app->getUser()->isGuest) :

    echo $this->render('main-login', [
        'content' => $content
    ]);
else :


    \backend\assets\AppAsset::register($this);

    \dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower/admin-lte/dist');

    $userIdentity = Yii::$app->getUser()->identity;

    ?>

    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>

    <?php
    $bodyClass = '';
    if (isset(Yii::$app->params['adminlteSkin'])) {
        $bodyClass .= ' ' . Yii::$app->params['adminlteSkin'];
    }
    ?>

    <body class="<?= $bodyClass; ?>">
    <?php $this->beginBody() ?>

    <div class="wrapper">
       <?= $content ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>

<?php endif; ?>
