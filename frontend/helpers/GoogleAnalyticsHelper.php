<?php

namespace frontend\helpers;

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
}
