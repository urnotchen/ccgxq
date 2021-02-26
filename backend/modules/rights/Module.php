<?php

namespace backend\modules\rights;

use backend\modules\setting\models\Notice;
use Yii;
use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\rights\controllers';

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
    public function getCategories()
    {/*{{{*/
        $idName = Notice::enum('cate_id');

        $items = [];
        $hasNoHighlighted = true;

        /* 主要分类条目 */

        foreach ($idName as $id => $name) {

            $linkOptions = [];

            $account_id = null;
            if (Yii::$app->controller->id == 'notice' && Yii::$app->controller->action->id == 'index') {
                $searchParams = Yii::$app->getRequest()->get('NoticeSearch');
                if (!empty($searchParams) && is_array($searchParams) && isset($searchParams['cate_id'])) {
                    $account_id = $searchParams['cate_id'];
                }
            }

            if ( $account_id !== null && $id == $account_id ) {
                $linkOptions = ['class' => 'active-item'];
                $hasNoHighlighted = $hasNoHighlighted && false;
            }

            $items[] = [
                'label' => $name,
                'url'   => Url::to([
                    '/setting/notice/index',
                    'NoticeSearch[cate_id]' => $id,
                ]),
                'linkOptions' => $linkOptions,
            ];
        }

        /* 全部分类条目 */

        $linkOptions = $hasNoHighlighted ? ['class' => 'active-item'] : [];

        array_unshift($items, [
                'label' => '全部',
                'url' => Url::to(['/setting/notice/index']),
                'linkOptions' => $linkOptions]
        );

        return $items;
    }
    protected function handleSidebarItems($event)
    {
        $items = \Yii::$app->sidebarItems->getItems();

//        $items[] = $this->prepareItem('部门管理', 'misc','policy');
//        $items[] = $this->prepareItem('公告管理', 'notice');
        $items[] = [
            'label' => '<span class="fa fa-cubes"></span> 文章列表',
            'items' => $this->getCategories(),
            'url' => ['/setting/notice/index'],
            'options' => [
                'class' => \bluelive\adminlte\widgets\SidebarActiveWidget::widget([
                    'activeArr' => [
                        'dashboard',
                    ],
                    'activeControllerArr' => [
                        'notice',
                    ],
                ]),
            ],
        ];
        $items[] = $this->prepareItem('管理员列表', 'user');

        $items[] = $this->prepareItem('角色管理', 'item','roles','rights');

        $items[] = $this->prepareItem('部门管理', 'partment');



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
