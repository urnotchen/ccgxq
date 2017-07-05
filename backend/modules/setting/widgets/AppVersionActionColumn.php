<?php
namespace backend\modules\setting\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * ShopActionColumn class file.
 * @Author haoliang
 * @Date 27.10.2015 10:54
 */
class AppVersionActionColumn extends \yii\grid\ActionColumn
{

    public $template = "{shortcut}";

    public function init()
    {/*{{{*/
        $this->injectButtons();
        parent::init();
    }/*}}}*/

    /**
     * @brief injectButtons
     *
     * todo 根据权限过滤按钮
     *
     * @return void
     */
    protected function injectButtons()
    {/*{{{*/

        $this->buttons['shortcut'] = function ($url, $model, $key) {
            $options = array_merge([
                'class' => 'shortcut',
                'url' => $url,
                'data-pjax' => '0',
            ], $this->buttonOptions);
            return Html::a('<span class="glyphicon glyphicon-flash"></span>', '##', $options);
        };
    }/*}}}*/

}
