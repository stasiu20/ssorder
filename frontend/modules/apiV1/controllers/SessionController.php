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
use \OpenApi\Annotations as OA;

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
     * @OA\Post(
     *     path="/session/login",
     *     operationId="login",
     *     tags={"Sessions"},
     *     summary="Login",
     *     description="Login return JWT token",
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="type",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="string"
     *                 ),
     *                 example={"type": "auth", "data": "ASD45SDF4GFDGDFGVMNY"}
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Wrong username/password"
     *     )
     * )
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
        return ['type' => 'auth', 'data' => $token->toString()];
    }

    /**
     * @OA\Delete(
     *     path="/session/logout",
     *     operationId="logout",
     *     tags={"Sessions"},
     *     summary="Logout",
     *     description="Logout",
     *     security={{"jwtToken": {}}},
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *      ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     * @throws BadRequestHttpException
     * @return Response
     */
    public function actionLogout()
    {
        $header = Yii::$app->request->getHeaders()->get(AccessTokenHelper::HEADER_NAME);
        $token = AccessTokenHelper::getTokenFromHeader($header);
        if (null === $token) {
            throw new BadRequestHttpException('Token is empty');
        }

        AccessTokenHelper::deleteToken($token);
        Yii::$app->user->logout();

        $response = new Response();
        return $response->setStatusCode(204);
    }
}
