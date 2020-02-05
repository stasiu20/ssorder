<?php

namespace frontend\controllers;

use common\models\ServerSentEvent;
use Predis\Client;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $client = new Client([
            'scheme' => 'tcp',
            'host' => getenv('REDIS_HOST'),
            'port' => getenv('REDIS_PORT'),
            'database' => getenv('REDIS_DATABASE'),
            'read_write_timeout' => 0
        ]);

        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->headers
            ->set('Content-Type', 'text/event-stream')
            ->set('Cache-Control', 'no-cache')
            ->set('Connection', 'keep-alive')
            ->set('X-Accel-Buffering', 'no');
        $response->send();
        if (ob_get_level() > 0) {
            ob_flush();
        }
        flush();

        $adapter = new \Superbalist\PubSub\Redis\RedisPubSubAdapter($client);
        $adapter->subscribe('sse', function ($message) {
            $event = new ServerSentEvent(['data' => json_encode(['message' => $message])]);
            echo $event;
            flush();
        });

        return $response;
    }
}
