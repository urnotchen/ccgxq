<?php

namespace backend\modules\statistics;
use backend\models\Type;
use backend\modules\movie\models\FilmProperty;
use Yii;
use yii\helpers\Url;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\statistics\controllers';

    public function init()
    {
        parent::init();

        /* 注入左侧栏分项 */
        $this->on(\yii\base\Module::EVENT_BEFORE_ACTION, [$this, 'handleSidebarItems']);

        \yii\base\Event::on(\yii\web\View::className(), \yii\web\View::EVENT_END_BODY, function ($event) {
            \backend\assets\AppAsset::addPageCss($event->sender, '/css/movie.css');
            \backend\assets\AppAsset::addPageScript($event->sender, '/js/movie.js');

        });
    }

    protected function handleSidebarItems($event)
    {
        $items = \Yii::$app->sidebarItems->getItems();

        $items[] = [
            'label' => '<span class="fa fa-cubes"></span> 用户列表',

            'url' => ['/statistics/front-user/index'],
            'options' => [
                'class' => \bluelive\adminlte\widgets\SidebarActiveWidget::widget([
                    'activeArr' => [
                        'dashboard',
                    ],
                    'activeControllerArr' => [
                        'statistics',
                    ],
                ]),
            ],
        ];

        \Yii::$app->sidebarItems->setItems($items);
    }

//    protected function prepareItem($tag, $controller, $action = 'index', $module = 'movie', $icon = 'fa-circle-o')
//    {
//        return [
//            'label' => "<i class='fa {$icon}'></i> <span> {$tag}</span>",
//            'url' => ["/{$module}/{$controller}/{$action}"],
//            'options' => [
//                'class' => \bluelive\adminlte\widgets\SidebarActiveWidget::widget([
//                    'activeArr' => [
//                        "{$controller}",
//                    ],
//                    'activeControllerArr' => [
//                        "{$module}",
//                    ],
//                ]),
//            ],
//        ];
//    }



    protected function prepareItemHeader($tag)
    {
        return sprintf('<li class="header"> %s </li>', $tag);
    }
}