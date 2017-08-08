<?php
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $userIdentity \common\models\BaseUser */

?>

<header class="main-header">
    <?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <div class="navbar-custom-menu-left" style="float: left;">

            <?php

            $items[] = [
                'text' => '<span class="sr-only">Toggle navigation</span>',
                'url' => '#',
                'options' => [
                    'class' => 'sidebar-toggle',
                    'data-toggle' => 'offcanvas',
                    'role' => 'button',
                ],
            ];

            $items[] = [
                'text' => '电影',
                'url' => ['/movie/movie/index'],
                'activeModule' => 'movie',
            ];

            $items[] = [
                'text' => '统计',
                'url' => ['/stat/stat/index'],
                'activeModule' => 'stat',
            ];

            $items[] = [
                'text' => '用户',
                'url' => ['/user/user/index'],
                'activeModule' => 'user',
            ];

            $items[] = [
                'text' => '设置',
                'url' => ['/setting/misc/policy'],
                'activeModule' => 'setting',
            ];

            echo \bluelive\adminlte\widgets\TopMenu::widget(['items' => $items]);

            ?>

        </div>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                            if(!Yii::$app->getUser()->isGuest){
//                                echo Html::img($userIdentity->avatar, ['class' => 'user-image', 'alt' => '用户头像']);
                                echo '<span class="hidden-xs">'.$userIdentity->username."</span>";
                            }
                        ?>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php if(!Yii::$app->getUser()->isGuest): ?>
                            <p>
                                <?= $userIdentity->username; ?> - Web Developer
                                <small>Member since <?= date('Y.m.d', $userIdentity->created_at); ?></small>
                            </p>
                            <?php endif ?>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-12 text-center">
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
