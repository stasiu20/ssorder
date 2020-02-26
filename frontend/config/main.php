<?php

use yii\web\JsonParser;
use Monolog\Logger;
use samdark\log\PsrTarget;
use mmo\yii2\helpers\AppVersionHelper;
use mmo\yii2\models\AppVersion;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$psrLogger = new \Monolog\Logger('ssorder_logger');
$psrLogger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout', YII_DEBUG ? \Monolog\Logger::DEBUG : Logger::NOTICE));

return [
    'id' => 'app-frontend',
    'language' => 'pl-PL',
    'name' => 'SSOrder',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', function () {
        $mediator = new \common\component\RocketChatOrderMediator();
        $mediator->mediate();

        $mediator = new \common\component\GAOrderMediator();
        $mediator->mediate();

        $mediator = new \common\component\UserRestApiMediator();
        $mediator->mediate();

        /** @var \common\component\SSEOrderMediator $mediator */
        $mediator = Yii::$container->get(\common\component\SSEOrderMediator::class);
        $mediator->mediate();
    }, function () {
        $filePath = Yii::getAlias('@root/VERSION');
        if (file_exists($filePath)) {
            \Yii::$app->view->params['appVersion'] = AppVersionHelper::factoryFromFile($filePath);
        } else {
            \Yii::$app->view->params['appVersion'] = new AppVersion([]);
        }
        \frontend\helpers\GoogleAnalyticsHelper::registerJs();
    }],
    'modules' => [
        'apiV1' => [
            'class' => \frontend\modules\apiV1\ApiV1Module::class
        ],
    ],
    'container' => [
        'definitions' => [
            \TheIconic\Tracking\GoogleAnalytics\Analytics::class => function () use ($params) {
                $analytics = new \TheIconic\Tracking\GoogleAnalytics\Analytics(true);
                $analytics->setProtocolVersion('1')
                    ->setTrackingId(empty($params['ga_tracking_id']) ? null : $params['ga_tracking_id'])
                    ->setAsyncRequest(false)
                    ->setClientId($params['ga_client_id']);
                if (!\Yii::$app->user->isGuest) {
                    $analytics->setUserId(\Yii::$app->user->id);
                }
                if (!empty(\Yii::$app->request->userIP)) {
                    $analytics->setIpOverride(\Yii::$app->request->userIP);
                }

                return $analytics;
            },
        ]
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
            'trustedHosts' => ['10.0.0.0/24'],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => PsrTarget::class,
                    'logger' => $psrLogger,
                    'levels' => ['error', 'warning', 'info'],
                    // It is optional parameter. Default value is false. If you use Yii log buffering, you see buffer write time, and not real timestamp.
                    // If you want write real time to logs, you can set addTimestampToContext as true and use timestamp from log event context.
                    'addTimestampToContext' => true,
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [//'/<id:\d+>' => 'site/index',
//                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                  //'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                'v1/<controller:\w+>/<action:\w+>' => 'apiV1/<controller>/<action>',
                'GET v1/restaurants/<restaurantId:\d+>/foods' => 'apiV1/restaurants/foods',
            ],
        ],
    ],
    'params' => $params,
];
