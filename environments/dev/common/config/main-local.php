<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
<<<<<<< HEAD
            'dsn' => 'mysql:host=database;dbname=tickets',
            'username' => 'tickets',
            'password' => '7f7AvS82PvJebYqk',
=======
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
