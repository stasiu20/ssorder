<?php

namespace frontend\helpers;

use yii\web\View;

class GoogleAnalyticsHelper
{
    public static function getTrackingId(): ?string
    {
        return \Yii::$app->params['ga_tracking_id'];
    }

    public static function isEnabledGA(): bool
    {
        return null !== \Yii::$app->params['ga_tracking_id'];
    }

    public static function getUserId(): ?int
    {
        return \Yii::$app->user->isGuest ? null : \Yii::$app->user->id;
    }

    public static function registerJs(): void
    {
        $content = \Yii::$app->view->renderFile(
            '@frontend/views/_partial/google-analytics.php'
        );
        \Yii::$app->view->registerJs(
            $content,
            View::POS_HEAD,
            'google-analytics'
        );
        if (self::isEnabledGA()) {
            \Yii::$app->view->registerJsFile(
                'https://www.google-analytics.com/analytics.js',
                ['position' => View::POS_HEAD, 'async' => 'async'],
                'google-analytics-script'
            );
        }
    }
}
