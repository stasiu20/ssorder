<?php

namespace frontend\modules\apiV1\controllers;

use common\models\AccessToken;
use common\models\User;
use frontend\modules\apiV1\models\request\LoginRequest;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use yii\rest\Controller;

class SessionController extends Controller
{
    public function actionLogin()
    {
        $loginRequest = new LoginRequest();
        $loginRequest->load(\Yii::$app->request->getBodyParams(), '');
        if (!$loginRequest->validate()) {
            return $loginRequest;
        }

        $user = User::findByUsername($loginRequest->userName);
        if (null === $user) {
            $loginRequest->addFailedLoginError();
            return $loginRequest;
        }
        if (!$user->validatePassword($loginRequest->password)) {
            $loginRequest->addFailedLoginError();
            return $loginRequest;
        }

        $time = time();
        $signer = new Sha256();
        $token = (new Builder())
            ->issuedAt($time) // Configures the time that the token was issue (iat claim)
            ->expiresAt($time + 3600) // Configures the expiration time of the token (exp claim)
            ->withClaim('uid', $user->getId()) // Configures a new claim, called "uid"
            ->getToken($signer, new Key('qwe')); // Retrieves the generated token

        AccessToken::saveTokenForUser($token, $user);
        return ['type' => 'auth', 'data' => (string)$token];
    }
}
