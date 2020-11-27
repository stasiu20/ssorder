<?php

namespace frontend\modules\apiV1\controllers;

use common\services\SymfonyApiClient;
use frontend\modules\apiV1\models\request\CreateWebpushRequest;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;

class WebpushController extends Controller
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verbFilter']['actions'] = [
            'create' => ['post'],
            'delete' => ['delete'],
        ];
        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                ['allow' => true, 'roles' => ['@']],
            ]
        ];
        return $parent;
    }

    /**
     * @OA\Post(
     *     path="/webpush",
     *     operationId="webpush.create",
     *     tags={"Webpush"},
     *     summary="Create webpush subscription",
     *     description="Create webpush subscription",
     *     security={{"jwtToken": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/CreateWebpushRequest")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *      ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data"
     *     )
     * )
     * @return Response|CreateWebpushRequest
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {
        $webpushRequest = new CreateWebpushRequest();
        $webpushRequest->load(\Yii::$app->request->getBodyParams(), '');
        if (!$webpushRequest->validate()) {
            return $webpushRequest;
        }

        /** @var SymfonyApiClient $symfonyApiClient */
        $symfonyApiClient = Yii::$container->get(SymfonyApiClient::class);
        $symfonyApiClient->createWebpush($webpushRequest);

        return \Yii::$app->getResponse()->setStatusCode(204);
    }

    /**
     * @OA\Delete(
     *     path="/webpush",
     *     operationId="webpush.delete",
     *     tags={"Webpush"},
     *     summary="Delete webpush subscription",
     *     description="Delete webpush subscription",
     *     security={{"jwtToken": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/CreateWebpushRequest")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *      ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data"
     *     )
     * )
     * @return Response|CreateWebpushRequest
     * @throws InvalidConfigException
     */
    public function actionDelete()
    {
        $webpushRequest = new CreateWebpushRequest();
        $webpushRequest->load(\Yii::$app->request->getBodyParams(), '');
        if (!$webpushRequest->validate()) {
            return $webpushRequest;
        }

        /** @var SymfonyApiClient $symfonyApiClient */
        $symfonyApiClient = Yii::$container->get(SymfonyApiClient::class);
        $symfonyApiClient->deleteWebpush($webpushRequest);

        return \Yii::$app->getResponse()->setStatusCode(204);
    }
}
