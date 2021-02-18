<?php

namespace backend\modules\comm;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\comm\controllers';

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

//        $items[] = $this->prepareItem('部门管理', 'misc','policy');
//        $items[] = $this->prepareItem('部门管理', 'partment');
//
//        $items[] = $this->prepareItem('管理员列表', 'user');
//
//        $items[] = $this->prepareItem('角色管理', 'item','roles','rights');
//
        $items[] = $this->prepareItem('邮件管理', 'email','index','comm');
        $items[] = $this->prepareItem('报修管理', 'repair','index','comm');
        $items[] = $this->prepareItem('电话簿', 'phone','index','comm');
        $items[] = $this->prepareItem('待办事项', 'dolist','index','comm');
        $items[] = $this->prepareItem('会诊管理', 'consultation','index','comm');
        $items[] = $this->prepareItem('会诊管理', 'conference','index','comm');



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