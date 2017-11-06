<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'timeZone' => 'Europe/Minsk',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [

        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => true,
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'a8_6aTDa0b9-yDBp7TTOsj8g3iRHA9j3',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/auth/'],
        ],
        'errorHandler' => [
            'class' => '\app\components\ErrorHandler',
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '/',
            'rules' => [

                'login' => 'admin/default/login/',
                'logout' => 'admin/default/logout/',
                'registration' => 'admin/default/registration/',
                'add' => 'place/add/',
                '404' => 'site/error404/',
                'feedback' => 'site/feedback/',
                'review' => 'place/review/',
                'place/<id:\d+>/<page>/' => 'place/<page>/',
                'place/<id:\d+>' => 'place/',

            ],
        ],

    ],

    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],


    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
