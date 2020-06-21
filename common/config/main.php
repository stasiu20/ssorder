<?php

use common\services\actions\CreateOrder;
use yii\queue\redis\Queue;
use yii\queue\serializers\JsonSerializer;
use yii\redis\Connection;
use yii\redis\Session;
use Aws\S3\S3Client;
use common\services\FileService;
use yii\di\Container;

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'container' => [
        'singletons' => [
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
            },
            \Prometheus\CollectorRegistry::class => function ($container, $params, $config) {
                return new \Prometheus\CollectorRegistry(new \Prometheus\Storage\Redis([
                    'host' => getenv('REDIS_HOST'),
                    'port' => (int)getenv('REDIS_PORT'),
                    'timeout' => 0.3,
                    'read_timeout' => 5,
                    'persistent_connections' => false,
                    'password' => null,
                ]));
            },
            \common\services\SSOrderMetrics::class => [function (Container $container, $params, $config) {
                /** @var \Prometheus\CollectorRegistry $collectorRegistry */
                $collectorRegistry = $container->get(\Prometheus\CollectorRegistry::class);
                return new \common\services\SSOrderMetrics(
                    $collectorRegistry,
                    $params['namespace']
                );
            }, ['namespace' => $params['prometheus.namespace']]],
            \Laminas\Diagnostics\Runner\Runner::class => function (Container $container, $params, $config) {
                $runner = new \Laminas\Diagnostics\Runner\Runner();
                $runner->addCheck(new \Laminas\Diagnostics\Check\GuzzleHttpService(
                    getenv('S3CLIENT_ENDPOINT'),
                    [],
                    [],
                    403
                ));
                $runner->addCheck(new \Laminas\Diagnostics\Check\GuzzleHttpService(
                    getenv('ROCKET_CHAT_ENDPOINT')
                ));
                $runner->addCheck(new \Laminas\Diagnostics\Check\PhpFlag(['expose_php'], false));
                $runner->addCheck(new \Laminas\Diagnostics\Check\Redis(
                    getenv('REDIS_HOST'),
                    getenv('REDIS_PORT'),
                    false
                ));
                $runner->addCheck(new \Laminas\Diagnostics\Check\PDOCheck(
                    getenv('DB_DSN'),
                    getenv('DB_USERNAME'),
                    getenv('DB_PASSWORD')
                ));

                return $runner;
            },
            \League\Fractal\Manager::class => function (Container $container, $params, $config) {
                return new \League\Fractal\Manager();
            },
            CreateOrder::class => function (Container $container, $params, $config) {
                return new CreateOrder(Yii::$app->order);
            },
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
            'connectionTimeout' => 2,
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
