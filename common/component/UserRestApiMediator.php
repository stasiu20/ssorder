<?php

namespace common\component;

use common\models\AccessToken;
use frontend\modules\apiV1\ApiV1Module;
use frontend\modules\apiV1\helpers\AccessTokenHelper;
use yii\web\User;
use yii\web\UserEvent;

class UserRestApiMediator
{
    public const JWT_SESSION_KEY =  'jwt';

    public function mediate(): void
    {
        \Yii::$app->user->on(
            User::EVENT_AFTER_LOGIN,
            [$this, 'getJWTTokenAfterLogin']
        );

        \Yii::$app->user->on(
            User::EVENT_BEFORE_LOGOUT,
            [$this, 'deleteJWTTokenBeforeLogout']
        );
    }

    public function getJWTTokenAfterLogin(UserEvent $event): void
    {
        if ($this->isRequestForApiModule()) {
            return;
        }

        /** @var \common\models\User $user */
        $user = $event->identity;
        $token = AccessTokenHelper::createTokenForUser($user);
        AccessToken::saveTokenForUser($token, $user);
        \Yii::$app->session->set(self::JWT_SESSION_KEY, (string)$token);
    }

    public function deleteJWTTokenBeforeLogout(UserEvent $event): void
    {
        if ($this->isRequestForApiModule()) {
            return;
        }

        $token = \Yii::$app->session->get(self::JWT_SESSION_KEY);
        if (empty($token)) {
            return;
        }
        AccessTokenHelper::deleteToken($token);
    }

    private function isRequestForApiModule(): bool
    {
        return \Yii::$app->controller->module instanceof ApiV1Module;
    }
}
