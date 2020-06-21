<?php

namespace frontend\modules\apiV1\controllers;

use common\enums\OrderSource;
use common\resources\OrderResource;
use common\services\actions\CreateOrder;
use frontend\models\Menu;
use frontend\modules\apiV1\models\request\CreateOrderRequest;
use League\Fractal\Manager;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\rest\Controller;
use \OpenApi\Annotations as OA;

class OrderController extends Controller
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verbFilter']['actions'] = [
            'create' => ['post'],
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
     *     path="/orders",
     *     operationId="order.create",
     *     tags={"Orders"},
     *     summary="Create order",
     *     description="Create new order",
     *     security={{"jwtToken": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/CreateOrderRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Order"),
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
     * @return array|CreateOrderRequest
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {
        $createOrderRequest = new CreateOrderRequest();
        $createOrderRequest->load(\Yii::$app->request->getBodyParams(), '');
        if (!$createOrderRequest->validate()) {
            return $createOrderRequest;
        }

        $menu = Menu::findOne($createOrderRequest->foodId);
        if (!$menu) {
            $createOrderRequest->addFoodError('Food not found');
        }
        if (!$menu->restaurant->isActive()) {
            $createOrderRequest->addFoodError('Cant create order for non active restaurant');
        }

        /** @var CreateOrder $createOrder */
        $createOrder = \Yii::$container->get(CreateOrder::class);
        $order = $createOrder->run($createOrderRequest, OrderSource::API());

        \Yii::$app->getResponse()->setStatusCode(201);
        /** @var Manager $fractalManager */
        $fractalManager = \Yii::$container->get(Manager::class);
        return $fractalManager->createData(OrderResource::factoryItem($order))->toArray();
    }
}
