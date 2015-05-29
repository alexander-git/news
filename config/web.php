<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'name' => 'news',
    'id' => 'app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'main/index',
    'aliases' => [
        //'@imagesNews' => dirname(__DIR__).'/web/images/news',
        '@imagesNews' => '@app/web/images/news',
        '@imagesNewsUrl' => '/images/news'
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'fZcUYBvbWkWIy4pSNmx-2kELwU4fDlnx',
            'enableCsrfValidation' => false,
            'enableCookieValidation' => true
        ],
        'urlManager' => [
            //'enablePrettyUrl' => true,
            //'showScriptName' => true,
            'rules' => [
                '/' => 'main/index',    
            ],
        ],
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        
        'formatter' => [
            'dateFormat' => 'dd-MM-Y',
            'booleanFormat' => ['Нет', 'Да']
        ],
        
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
