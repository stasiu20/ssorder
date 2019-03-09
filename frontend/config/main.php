<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

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
    }],
    'container' => [
        'definitions' => [
            \TheIconic\Tracking\GoogleAnalytics\Analytics::class => function() use ($params) {
                $analytics = new \TheIconic\Tracking\GoogleAnalytics\Analytics(true);
                $analytics->setProtocolVersion('1')
                    ->setTrackingId(empty($params['ga_tracking_id']) ? null : $params['ga_tracking_id'])
                    ->setAsyncRequest(true)
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
                'application/json' => 'yii\web\JsonParser',
            ]
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
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
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
//                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
