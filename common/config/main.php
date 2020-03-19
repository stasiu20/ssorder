<?php

use yii\queue\redis\Queue;
use yii\queue\serializers\JsonSerializer;
use yii\redis\Connection;
use yii\redis\Session;
use Aws\S3\S3Client;
use common\services\FileService;
use yii\di\Container;

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'container' => [
        'definitions' => [
            S3Client::class => function ($container, $params, $config) {
                return new S3Client([
                    'version' => 'latest',
                    'region'  => 'us-east-1',
                    'endpoint' => getenv('S3CLIENT_ENDPOINT'),
                    'use_path_style_endpoint' => true,
                    'credentials' => [
                        'key'    => getenv('MINIO_ACCESS_KEY'),
                        'secret' => getenv('MINIO_SECRET_KEY'),
                    ],
                ]);
            },
            FileService::class => function (Container $container, $params, $config) {
                /** @var S3Client $s3Client */
                $s3Client = $container->get(S3Client::class);
                return new FileService($s3Client);
            },
            \common\component\SSEOrderMediator::class => function (Container $container, $params, $config) {
                return new \common\component\SSEOrderMediator(Yii::$app->redis, Yii::$app->order);
            }
        ]
    ],
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
        'session' => [
            'class' => Session::class,
        ],
        'redis' => [
            'class' => Connection::class,
            'hostname' => getenv('REDIS_HOST'),
            'port' => getenv('REDIS_PORT'),
            'database' => getenv('REDIS_DATABASE'),
            'connectionTimeout' => 5,
            'dataTimeout' => 5,
            'retries' => 3,
            'retryInterval' => 500,
        ],
        'queue' => [
            'class' => Queue::class,
            'channel' => 'queue',
            'serializer' => JsonSerializer::class,
        ],
    ],
];
