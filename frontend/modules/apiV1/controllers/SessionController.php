<?php

namespace frontend\modules\apiV1\controllers;

use common\models\AccessToken;
use common\models\User;
use frontend\modules\apiV1\models\request\LoginRequest;
use frontend\modules\apiV1\helpers\AccessTokenHelper;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class SessionController extends Controller
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verbFilter']['actions'] = [
            'login' => ['post'],
            'logout' => ['delete'],
        ];
        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                ['actions' => ['login'], 'allow' => true, 'roles' => ['?']],
                ['actions' => ['logout'], 'allow' => true, 'roles' => ['@']],
            ]
        ];
        return $parent;
    }

    /**
     * @return array|LoginRequest
     * @throws InvalidConfigException
     */
    public function actionLogin()
    {
        $loginRequest = new LoginRequest();
        $loginRequest->load(Yii::$app->request->getBodyParams(), '');
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

        $token = AccessTokenHelper::createTokenForUser($user);
        AccessToken::saveTokenForUser($token, $user);
        return ['type' => 'auth', 'data' => (string)$token];
    }

    /**
     * @throws BadRequestHttpException
     * @throws Throwable
     * @throws StaleObjectException
     * @return Response
     */
    public function actionLogout()
    {
        $header = Yii::$app->request->getHeaders()->get(AccessTokenHelper::HEADER_NAME);
        $token = AccessTokenHelper::getTokenFromHeader($header);
        if (null === $token) {
            throw new BadRequestHttpException('Token is empty');
        }
        $accessToken = AccessToken::getByToken($token);
        if ($accessToken) {
            $accessToken->delete();
            Yii::$app->user->logout();
        }

        $response = new Response();
        return $response->setStatusCode(204);
    }
}
