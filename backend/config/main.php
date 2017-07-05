<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => '看啥电影»管理后台',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'modules' => [
        'movie' => [
            'class' => 'backend\modules\movie\Module',
            'as access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ],
        'setting' => [
            'class' => 'backend\modules\setting\Module',
            'as access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ],
        'statistics' => [
            'class' => 'backend\modules\statistics\Module',
            'as access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
//            'class' => 'backend\components\User',
//            'identityClass' => 'dektrium\user\Models\User',
//            'as backend' => 'dektrium\user\filters\BackendFilter',
//            'loginUrl'        => '/user/security/login',
            'enableUnconfirmedLogin' => true,
//            'enableAutoLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin']
        ],

    ],
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'app' => 'yii.php',
                        'app/error' => 'error.php',
                    ],

                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ]
        ],
//        'user' => [
//            'class'           => 'backend\components\User',
//            'identityClass'   => 'dektrium\user\Models\User',
//            'enableAutoLogin' => true,
//        ],
        'session' => [
            'class' => 'yii\web\Session',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'i18n' => [
//            'translations' => [
//                'yii' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@app/messages',
//                ],
//            ],
//        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'forceCopy' => false,
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'css' => [
                        '/css/AdminLTE.min.css',
                    ],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules' => [
                ''       => 'site/index',
                'logout' => 'site/logout',
                '<controller:[a-z-]+>' => '<controller>/index',
                '<controller:[a-z-]+>/' => '<controller>/index',
                '<controller:[a-z-]+>/<action:[a-z-]+>' => '<controller>/<action>',
                '<controller:[a-z-]+>/<action:[a-z-]+>/<id:[0-9]+>' => '<controller>/<action>',
                '<module:[a-z-]+>/<controller:[a-z-]+>/<action:[a-z-]+>' => '<module>/<controller>/<action>',
            ],
        ],
        'urlManagerLogin' => [
            'class'               => 'yii\web\urlManager',
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules' => [
                'login'   => 'site/login',
                'logout'  => 'site/logout',
            ],
        ],
        'sidebarItems' => [
            'class' => 'bluelive\adminlte\components\SidebarItems',
        ],
        'JPush' => [
            'class' => 'backend\components\JPush',
        ],
    ],
    'params' => $params,
];
