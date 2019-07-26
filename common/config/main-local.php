<?php
return [
    'components' => [
        'db' => [
            'class' => getenv('DB_CLASS'),
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => getenv('DB_CHARSET'),
        ],
        'mailer' => [
            'class' => getenv('MAILER_CLASS'),
            'viewPath' => getenv('MAILER_VIEW_PATH'),
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => getenv('MAILER_USE_FILE_TRANSPORT'),
            'transport' => [
                'class' => getenv('MAILER_TRANSPORT_CLASS'),
                'host' => getenv('MAILER_SMTP_HOST'),
                'username' => getenv('MAILER_SMTP_USERNAME'),
                'password' => getenv('MAILER_SMTP_PASSWORD'),
                'port' => getenv('MAILER_SMTP_PORT'),
                'encryption' => getenv('MAILER_SMTP_ENCRYPTION'),
            ],
        ],
        'rocketChat' => [
            'endpoint' => getenv('ROCKET_CHAT_ENDPOINT'),
            'token' => getenv('ROCKET_CHAT_TOKEN'),
        ]
    ],
];
