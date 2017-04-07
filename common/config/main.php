<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class'    => 'yii\db\Connection',
        ],
        'dbUser' => [
            'class'    => 'yii\db\Connection',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'blueliveMailer' => [
            'class' => 'common\components\BlueliveMailer',
        ],
        'redis' => [
            'class' => 'common\components\Redis',
        ],
        'formatter' => [
            'dateFormat'     => 'php:Y-m-d H:i:s',
            'timeFormat'     => 'php:H:i:s',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'bluelive' => [
                    'class' => 'bluelive\authclient\Bluelive',
                ],
            ],
        ],
        'dateFormat' => [
            'class' => 'common\components\DateFormat',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'log' => [
            'targets' => [
                [
                    //数据库存储日志对象
                    'class' => 'yii\log\DbTarget',
                    'db' => 'db',
                    'logTable' => 'log',
                    'levels' => ['error', 'warning'],
                ]
            ],
        ],
    ],
];
