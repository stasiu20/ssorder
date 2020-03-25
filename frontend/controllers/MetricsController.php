<?php

namespace frontend\controllers;

use mmo\yii2\actions\PrometheusMetrics;
use Prometheus\CollectorRegistry;
use yii\web\Controller;

class MetricsController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => PrometheusMetrics::class,
                'collectorRegistry' => \Yii::$container->get(CollectorRegistry::class)
            ]
        ];
    }
}
