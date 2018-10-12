<?php
return [
    'name' => 'gofunding.ga',  // setting domain name
    'components' => [
        'db' => [
            // setting your db local
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=gofunding',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false, // false agar bisa kirim lewat online
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '', // host mail server
                'username' => '',
                'password' => '', // setting sesuai kebutuhan
                'port' => '465',
                'encryption' => 'tls',
            ],
        ],
    ],
];