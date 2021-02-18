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
    /**
     * @var User
     */
    private $_user;

    public function __construct(\yii\web\User $user = null)
    {
        $this->_user = $user ?: \Yii::$app->user;
    }

    public function mediate(): void
    {
        $this->_user->on(
            User::EVENT_AFTER_LOGIN,
            [$this, 'getJWTTokenAfterLogin']
        );

        $this->_user->on(
            User::EVENT_BEFORE_LOGOUT,
            [$this, 'deleteJWTTokenBeforeLogout']
        );
    }

    public function getJWTTokenAfterLogin(UserEvent $event): void
    {
        if ($this->isRequestForApiModule($event)) {
            return;
        }

        /** @var \common\models\User $user */
        $user = $event->identity;
        $token = AccessTokenHelper::createTokenForUser($user);
        AccessToken::saveTokenForUser($token, $user);
        \Yii::$app->session->set(self::JWT_SESSION_KEY, $token->toString());
    }

    public function deleteJWTTokenBeforeLogout(UserEvent $event): void
    {
        if ($this->isRequestForApiModule($event)) {
            return;
        }

        $token = \Yii::$app->session->get(self::JWT_SESSION_KEY);
        if (empty($token)) {
            return;
        }
        AccessTokenHelper::deleteToken($token);
    }

    private function isRequestForApiModule(UserEvent $event): bool
    {
        $controller = \Yii::$app->controller;
        // jeden z paneli pakietu yii2-debug sprwadza czy uzytkownik jest zalogowany.
        // Wyzwala sie akcja autologowania na podstawie cookie.
        // Parsowanie requesta jeszcze sie nie odbylo.
        // Nie mamy wiec modulu ani kontrolera skad przychodzi request.
        // API nie korzysta z cookie wiec wiemy ze te logowanie przyszlo z web.
        if (!$controller && $event->cookieBased) {
            return false;
        }
        return $controller->module instanceof ApiV1Module;
    }
}
