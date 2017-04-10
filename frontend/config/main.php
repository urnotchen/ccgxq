<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'db' => [
            'enableQueryCache' => true,
            'enableSchemaCache' => true,
        ],
        'dbUser' => [
            'enableQueryCache' => true,
            'enableSchemaCache' => true,
        ],
        'request' => [
            'class' => 'frontend\components\rest\Request',
        ],
        'user' => [
            'class'         => 'frontend\components\rest\User',
            'identityClass' => 'frontend\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules' => [

                '' => 'site/index',

                'v1' => 'v1',
                'v1/<controller:[a-z-]+>/<action:[a-z-]+>' => 'v1/<controller>/<action>',

                '<controller:[a-z-]+>/<action:[a-z-]+>' => '<controller>/<action>',

            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'forceCopy' => false,
        ]
    ],
    'modules' => [
        'v1' => [
            'class' => 'frontend\modules\v1\Module',
        ],
    ],
    'params' => $params,
];
