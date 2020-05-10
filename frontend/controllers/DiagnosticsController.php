<?php

namespace frontend\controllers;

use Laminas\Diagnostics\Runner\Runner;
use mmo\yii2\actions\LaminasDiagnostics;
use yii\web\Controller;

class DiagnosticsController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => LaminasDiagnostics::class,
                'runner' => \Yii::$container->get(Runner::class),
            ]
        ];
    }
}
