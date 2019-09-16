<?php
<<<<<<< HEAD
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=yii2advanced_test',
            ]
        ],
    ]
);
=======
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced_test',
        ],
    ],
];
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
