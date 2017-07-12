<?php

namespace backend\modules\stat;

use backend\models\StatUserAction;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\stat\controllers';

    public function init()
    {
        parent::init();

        /* 注入左侧栏分项 */
        $this->on(\yii\base\Module::EVENT_BEFORE_ACTION, [$this, 'handleSidebarItems']);

        \yii\base\Event::on(\yii\web\View::className(), \yii\web\View::EVENT_END_BODY, function ($event) {
//            \backend\assets\AppAsset::addPageCss($event->sender, '/css/stat.css');
//            \backend\assets\AppAsset::addPageScript($event->sender, '/js/stat.js');
        });
    }

    protected function handleSidebarItems($event)
    {
        $items = Yii::$app->sidebarItems->getItems();

        $items[] = $this->prepareItem('活跃用户', 'stat');
        $items[] = $this->prepareItem('电影统计', 'stat-movie');
        $items[] = $this->prepareItem('评论统计', 'stat-user-action','index?StatUserActionSearch[type] = '.StatUserAction::TYPE_COMMENT);
        $items[] = $this->prepareItem('电影斩标记', 'stat-user-action','index?StatUserActionSearch[type] = '.StatUserAction::TYPE_CHOICE_BY_ZHAN);

        Yii::$app->sidebarItems->setItems($items);
    }

    protected function prepareItem($tag, $controller, $action = 'index', $module = 'stat', $icon = 'fa-circle-o')
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