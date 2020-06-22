<?php

use hyperia\security\Headers;
use yii\bootstrap4\LinkPager;
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
    'defaultRoute' => 'restaurants',
    'aliases' => [
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => ['log', 'headers', function () {
        $mediator = new \common\component\RocketChatOrderMediator();
        $mediator->mediate();

        $mediator = new \common\component\GAOrderMediator();
        $mediator->mediate();

        $mediator = new \common\component\UserRestApiMediator();
        $mediator->mediate();

        /** @var \common\component\Order $order */
        $order = \Yii::$app->order;
        /** @var \common\services\SSOrderMetrics $metrics */
        $metrics = Yii::$container->get(\common\services\SSOrderMetrics::class);
        $mediator = new \common\events\listeners\NewOrderPrometheus(
            $order,
            $metrics
        );
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
            yii\grid\GridView::class => [
                'pager' => [
                    'class' => LinkPager::class,
                ],
            ],
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

        'assetManager' => [
            'bundles' => [
                \yii\bootstrap\BootstrapAsset::class => [
                    'sourcePath' => null,
                    'css' => [],
                ],
                \yii\bootstrap\BootstrapPluginAsset::class => [
                    'sourcePath' => null,
                    'js' => [],
                ],
                \yii\bootstrap4\BootstrapAsset::class => [
                    'sourcePath' => null,
                    'css' => [],
                ],
                \yii\bootstrap4\BootstrapPluginAsset::class => [
                    'sourcePath' => null,
                    'js' => [],
                ],
//                \yii\web\JqueryAsset::class => [
//                    'sourcePath' => null,
//                    'js' => [],
//                    'depends' => [
//                        \app\assets\AppAsset::class
//                    ]
//                ],
//                \yii\web\YiiAsset::class => [
//                    'sourcePath' => null,
//                    'js' => [],
//                    'depends' => [
//                        \app\assets\AppAsset::class
//                    ]
//                ],
//                \yii\grid\GridViewAsset::class => [
//                    'sourcePath' => null,
//                    'js' => []
//                ],
//                \yii\captcha\CaptchaAsset::class => [
//                    'sourcePath' => null,
//                    'js' => [],
//                ],
//                \yii\widgets\MaskedInputAsset::class => [
//                    'sourcePath' => null,
//                    'js' => []
//                ],
//                \yii\widgets\ActiveFormAsset::class => [
//                    'sourcePath' => null,
//                    'js' => []
//                ],
//                \yii\widgets\PjaxAsset::class => [
//                    'sourcePath' => null,
//                    'js' => [],
//                ],
//                \yii\validators\PunycodeAsset::class => [
//                    'sourcePath' => null,
//                    'js' => []
//                ],
//                \yii\validators\ValidationAsset::class => [
//                    'sourcePath' => null,
//                    'js' => []
//                ],
//                \yii\gii\GiiAsset::class => [
//                    'sourcePath' => null,
//                    'js' => [],
//                    'css' => []
//                ],
//                \yii\debug\DebugAsset::class => [
//                    'sourcePath' => null,
//                    'js' => [],
//                    'css' => [],
//                    'depends' => [
//                        \app\assets\Yii2DebugAsset::class
//                    ]
//                ],
//                \yii\debug\TimelineAsset::class => [
//                    'sourcePath' => null,
//                    'js' => [],
//                    'css' => []
//                ],
//                \yii\debug\DbAsset::class => [
//                    'sourcePath' => null,
//                    'js' => [],
//                    'css' => []
//                ],
//                \yii\debug\UserswitchAsset::class => [
//                    'sourcePath' => null,
//                    'js' => []
//                ]
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'restaurants' => 'restaurants/index',
                [
                    'pattern' => 'restaurants/<id:\d+>/update',
                    'route' => 'restaurants/update',
                ],
                [
                    'pattern' => 'restaurants/<id:\d+>',
                    'route' => 'restaurants/details',
                ],
                'restaurants/add' => 'restaurants/create',
                'images/<id:\d+>/delete' => 'restaurants/delete-image',

                'menu/<id:\d+>' => 'menu/view',
                'menu/<id:\d+>/delete' => 'menu/delete',
                'menu/<id:\d+>/update' => 'menu/update',
                'restaurants/<id:\d+>/add-food' => 'menu/create',

                //'/<id:\d+>' => 'site/index',
//                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                  //'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                'v1/restaurants' => 'apiV1/restaurants/index',
                'v1/restaurants/<restaurantId:\d+>/foods' => 'apiV1/restaurants/foods',
                'POST v1/orders' => 'apiV1/order/create',
                'v1/<controller:\w+>/<action:\w+>' => 'apiV1/<controller>/<action>',
            ],
        ],
        'headers' => [
            'class' => Headers::class,
            'xssProtection' => true,
            'xFrameOptions' => 'DENY',
            'upgradeInsecureRequests' => false,
            'cspDirectives' => [
                'script-src' => "'self' 'unsafe-inline' www.google-analytics.com",
                'style-src' => "'self' 'unsafe-inline' fonts.googleapis.com",
                'img-src' => "'self' data: www.google-analytics.com *.lvh.me *.ssorder.snlb.pl stats.g.doubleclick.net",
                'connect-src' => '*',
                'font-src' => '* data:',
                'object-src' => '*',
                'media-src' => '*',
                'form-action' => '*',
                'frame-src' => "'self'",
                'child-src' => '*',
                'worker-src' => "'self'",
                'manifest-src' => "'self'",
            ],
            'referrerPolicy' => 'no-referrer',
        ]
    ],
    'params' => $params,
    'as prometheus' => [
        'class' => \mmo\yii2\behaviors\PrometheusBehavior::class,
        'namespace' => $params['prometheus.namespace'],
        'collectorRegistry' => \Prometheus\CollectorRegistry::class
    ],
    'as metrics' => [
        'class' => \mmo\yii2\filters\PrometheusWebMetrics::class,
        'namespace' => 'ssorder2',
        'collectorRegistry' => \Prometheus\CollectorRegistry::class,
    ]
];
