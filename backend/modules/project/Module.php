<?php

namespace backend\modules\project;

use Yii;
use yii\helpers\Url;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\project\controllers';

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

        $items[] = $this->prepareItem('项目分类', 'project-category');

        $items[] = $this->prepareItem('项目管理', 'project');

        $items[] = $this->prepareItem('审批业务', 'approval');

        $items[] = $this->prepareItem('在线审批', 'deal');




        \Yii::$app->sidebarItems->setItems($items);
    }

    protected function prepareItem($tag, $controller, $action = 'index', $module = 'project', $icon = 'fa-circle-o')
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