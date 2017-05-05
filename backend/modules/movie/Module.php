<?php

namespace backend\modules\movie;
use backend\models\Type;
use backend\modules\movie\models\FilmProperty;
use Yii;
use yii\helpers\Url;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\movie\controllers';

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
            'label' => '<span class="fa fa-cubes"></span> 电影列表',
            'items' => $this->getUserCategories(),
            'url' => ['/movie/movie/index'],
            'options' => [
                'class' => \bluelive\adminlte\widgets\SidebarActiveWidget::widget([
                    'activeArr' => [
                        'dashboard',
                    ],
                    'activeControllerArr' => [
                        'movie',
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

    public function getUserCategories()
    {/*{{{*/
        $idName = FilmProperty::enum('property');

        $items = [];
        $hasNoHighlighted = true;

        /* 主要分类条目 */

        foreach ($idName as $id => $name) {

            $linkOptions = [];

            $account_id = null;
            if (Yii::$app->controller->id == 'movie' && Yii::$app->controller->action->id == 'index') {
                $searchParams = Yii::$app->getRequest()->get('MovieSearch');
                if (!empty($searchParams) && is_array($searchParams) && isset($searchParams['film_property'])) {
                    $account_id = $searchParams['film_property'];
                }
            }

            if ( $account_id !== null && $id == $account_id ) {
                $linkOptions = ['class' => 'active-item'];
                $hasNoHighlighted = $hasNoHighlighted && false;
            }

            $items[] = [
                'label' => $name,
                'url'   => Url::to([
                    '/movie/movie/index',
                    'MovieSearch[film_property]' => $id,
                ]),
                'linkOptions' => $linkOptions,
            ];
        }

        /* 全部分类条目 */

        $linkOptions = $hasNoHighlighted ? ['class' => 'active-item'] : [];

        array_unshift($items, [
                'label' => '全部',
                'url' => Url::to(['/movie/movie/index']),
                'linkOptions' => $linkOptions]
        );

        return $items;
    }

    protected function prepareItemHeader($tag)
    {
        return sprintf('<li class="header"> %s </li>', $tag);
    }
}