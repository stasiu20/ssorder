<?php

namespace frontend\modules\apiV1;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\web\Response;

/**
 * apiV1 module definition class
 */
class ApiV1Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\apiV1\controllers';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        Yii::$app->user->switchIdentity(null);
        Yii::$app->user->enableSession = false;
        Yii::$app->request->enableCsrfCookie = false;
    }

    public function behaviors()
    {
        return [
            'cors' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => explode(',', getenv('CORS_ALLOWED_ORIGIN')),
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'jwtAuth' => [
                'class' => HttpBearerAuth::class,
                'except' => ['session/login']
            ],
        ];
    }
}
