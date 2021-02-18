<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => '高新区电子政务',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'modules' => [
        'project' => [
            'class' => 'backend\modules\project\Module',
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
        'comm' => [
            'class' => 'backend\modules\comm\Module',
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
        'rights' => [
            'class' => 'backend\modules\rights\Module',
//            'as access' => [
//                'class' => \yii\filters\AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['?'],
//                        'matchCallback' => function ($rule, $action) {return true;
////                            return \Yii::$app->user->can(\backend\modules\rights\components\Rights::PERMISSION_RIGHTS_MANAGE);
//                        },
//                    ],
//                ],
//            ],
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
        'order' => [
            'class' => 'backend\modules\order\Module',
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
            'class' => 'backend\modules\user\Module',
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
//        'user' => [
//            'class' => 'dektrium\user\Module',
//            'enableUnconfirmedLogin' => true,
//            'confirmWithin' => 21600,
//            'cost' => 12,
//            'admins' => ['admin']
//        ],


    ],
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                    'fileMap' => [
                        '*' => 'yii.php',
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
        'timeFormatter' => [
            'class' => 'backend\components\TimeFormatter',
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
        'user' => [
            'class'           => 'backend\components\User',
            'identityClass'   => 'common\models\BaseUser',
            'enableAutoLogin' => true,
            'loginUrl'        => ['site/login'],
            'identityCookie'  => [
                'name'     => '_identity',
                'httpOnly' => true,
            ],
        ],
    ],
    'params' => $params,
];
