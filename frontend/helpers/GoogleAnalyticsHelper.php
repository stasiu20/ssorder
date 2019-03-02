<?php

namespace frontend\helpers;


class GoogleAnalyticsHelper
{
    public static function getTrackingId()
    {
        return \Yii::$app->params['ga_tracking_id'];
    }

    public static function isEnabledGA()
    {
        return null !== \Yii::$app->params['ga_tracking_id'];
    }

    public static function getUserId()
    {
        return \Yii::$app->user->isGuest ? null : \Yii::$app->user->id;
    }
}
