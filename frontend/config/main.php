<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
<<<<<<< HEAD
=======
    'language' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
<<<<<<< HEAD
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
=======
            'baseUrl' => '/admin',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
<<<<<<< HEAD
=======

>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
