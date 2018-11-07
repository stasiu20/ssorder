<?php

namespace frontend\rocketChat\filters;

use yii\filters\auth\AuthMethod;

class AuthToken extends AuthMethod
{
    /** @var string|null */
    public $token;

    public function authenticate($user, $request, $response)
    {
        $token = $request->getBodyParam('token', null);

        if ($this->token) {
            if ($this->token !== $token) {
                $this->handleFailure($response);
            }
        } else {
            $this->handleFailure($response);
        }

        return $user;
    }

    protected function isOptional($action)
    {
        return false;
    }
}
