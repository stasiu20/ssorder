<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
        ],
    ],
    'container' => [
        'singletons' => [
            \Prometheus\CollectorRegistry::class => function ($container, $params, $config) {
                return new \Prometheus\CollectorRegistry(new \Prometheus\Storage\InMemory([]));
            },

        ]
    ],
];
