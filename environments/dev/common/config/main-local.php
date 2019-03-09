<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=mysql;dbname=ssorder;port=3306',
            'username' => 'ssorder',
            'password' => 'ssorderpassword',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mailhog',
                'username' => 'ssorder@example.com',
                'password' => 'secret',
                'port' => '1025',
//                'encryption' => 'tls',
            ],
        ],
        'rocketChat' => [
            'endpoint' => 'http://rocketchat.lvh.me:3000',
            'token' => 'HHPL4h7SrvCcfHBrj/4invwR2sgveqdKjNtRmm96h7b6sAAN8PTQyzZPytbcTTojJD',
        ]
    ],

];
