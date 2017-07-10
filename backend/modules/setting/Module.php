<?php

namespace backend\modules\setting;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\setting\controllers';

    public function init()
    {
        parent::init();

        /* 注入左侧栏分项 */
        $this->on(\yii\base\Module::EVENT_BEFORE_ACTION, [$this, 'handleSidebarItems']);

        \yii\base\Event::on(\yii\web\View::className(), \yii\web\View::EVENT_END_BODY, function ($event) {
//            \backend\assets\AppAsset::addPageCss($event->sender, '/css/movie.css');
            \backend\assets\AppAsset::addPageCss($event->sender, '/css/feedback.css');
            \backend\assets\AppAsset::addPageScript($event->sender, '/js/feedback.js');
            \backend\assets\AppAsset::addPageCss($event->sender, '/css/setting.css');
            \backend\assets\AppAsset::addPageScript($event->sender, '/js/setting.js');

        });
    }

    protected function handleSidebarItems($event)
    {
        $items = \Yii::$app->sidebarItems->getItems();

        $items[] = $this->prepareItem('用户协议', 'misc','index');

        $items[] = $this->prepareItem('管理员列表', 'user');

        $items[] = $this->prepareItem('反馈列表', 'feedback');

        $items[] = $this->prepareItem('APP版本', 'app-version');

        \Yii::$app->sidebarItems->setItems($items);
    }

    protected function prepareItem($tag, $controller, $action = 'index', $module = 'setting', $icon = 'fa-circle-o')
    {
        return [
            'label' => "<i class='fa {$icon}'></i> <span> {$tag}</span>",
            'url' => ["/{$module}/{$controller}/{$action}"],
            'options' => [
                'class' => \bluelive\adminlte\widgets\SidebarActiveWidget::widget([
                    'activeArr' => [
                        "{$controller}",
                    ],
                    'activeControllerArr' => [
                        "{$module}",
                    ],
                ]),
            ],
        ];
    }

    protected function prepareItemHeader($tag)
    {
        return sprintf('<li class="header"> %s </li>', $tag);
    }
}