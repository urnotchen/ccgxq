<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public static function addPageScript(\yii\web\View $view, $jsFile) {
        $view->registerJsFile($jsFile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }

    public static function addPageCss(\yii\web\View $view, $cssFile) {
        $view->registerCssFile($cssFile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
}
