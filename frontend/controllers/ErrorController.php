<?php

namespace frontend\controllers;

use mmo\yii2\actions\ReportingLogger;
use yii\web\Controller;

class ErrorController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'reporting' => [
                'class' => ReportingLogger::class,
                'logCategory' => 'application.js'
            ],
        ];
    }
}
