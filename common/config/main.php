<?php
return [
    'timeZone' => 'Asia/Shanghai',
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
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//        ],
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
        'ksmovieMailer' => [
            'class' => 'common\components\Mailer',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'constructArgs' => ['smtp.ym.163.com', 25],
                'host' => 'smtp.ym.163.com',  //每种邮箱的host配置不一样
                'username' => 'useradmin@bluelive.cn14141',
                'password' => 'Lgdev20174114141',
//            'port' => '25',
//            'encryption' => 'tls',

            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['useradmin@bluelive.cn'=>'看啥电影']
            ],
        ],
    ],
];
