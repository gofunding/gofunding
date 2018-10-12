<?php
return [
    'components' => [
        'db' => [
            // setting your db local
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=c7tnde',
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
                'host' => 'smtp.gmail.com',
                'username' => '',
                'password' => '', // setting sesuai kebutuhan
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
];