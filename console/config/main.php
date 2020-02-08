<?php

use yii\faker\FixtureController;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'name' => 'SSOrder',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'scriptUrl' => 'https://ssorder.snlb.pl',
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'hostInfo' => getenv('PUBLIC_DOMAIN'),
        ],

    ],
    'params' => $params,
    'controllerMap' => [
        'fixture' => [
            'class' => FixtureController::class,
            'templatePath' => '@tests/unit/fixtures/data/templates/fixtures',
            'fixtureDataPath' => '@tests/unit/fixtures/data',
            'namespace' => 'common\tests\unit\fixtures',
        ],
    ],
];
