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
            #'useFileTransport' => true,
        ],
        'rocketChat' => [
            'endpoint' => 'http://rocketchat.lvh.me:3000',
            'token' => 'puhPSTPcA6zfXQtZZ/9dbe4Az3S72e4fFbpTaY3fDMufRszeZaTuQfaESaCp8cSzkk',
        ]
    ],

];
