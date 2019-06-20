<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_Transport_SendmailTransport',
            ],
        ],
        'rocketChat' => [
            'class' => \common\component\RocketChat::className(),
            'endpoint' => 'TO_OVERWRITE',
            'token' => 'TO_OVERWRITE',
        ],
        'order' => [
            'class' => \common\component\Order::className(),
        ],
    ],
];
