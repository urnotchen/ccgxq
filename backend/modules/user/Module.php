<?php

namespace backend\modules\user;



use Yii;
use yii\helpers\Url;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\user\controllers';

    public function init()
    {
        parent::init();

        /* 注入左侧栏分项 */
        $this->on(\yii\base\Module::EVENT_BEFORE_ACTION, [$this, 'handleSidebarItems']);

        \yii\base\Event::on(\yii\web\View::className(), \yii\web\View::EVENT_END_BODY, function ($event) {


        });
    }

    protected function handleSidebarItems($event)
    {
        $items = \Yii::$app->sidebarItems->getItems();

        $items[] = [
            'label' => '<span class="fa fa-cubes"></span> 留言咨询',
            'items' => [],
            'url' => ['/user/message/index'],
            'options' => [
                'class' => \bluelive\adminlte\widgets\SidebarActiveWidget::widget([
                    'activeArr' => [
                        'dashboard',
                    ],
                    'activeControllerArr' => [
                        'message',
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