<?php

namespace common\services\actions;

use common\component\Order as OrderComponent;
use common\enums\OrderSource;
use common\models\Order;
use common\repositories\MenuRepository;
use frontend\modules\apiV1\models\request\CreateOrderRequest;
use yii\web\IdentityInterface;

class CreateOrder
{
    /**
     * @var OrderComponent
     */
    private $_orderComponent;
    /**
     * @var MenuRepository
     */
    private $_menuRepository;

    public function __construct(OrderComponent $orderComponent, MenuRepository $menuRepository)
    {
        $this->_orderComponent = $orderComponent;
        $this->_menuRepository = $menuRepository;
    }

    public function run(CreateOrderRequest $orderRequest, OrderSource $source, IdentityInterface $identity = null): Order
    {
        $menu = $this->_menuRepository->findOne($orderRequest->foodId);
        if (!$menu) {
            throw new \LogicException(sprintf('Menu #%d not found', $orderRequest->foodId));
        }

        if (!$menu->restaurant->isActive()) {
            throw new \LogicException(sprintf('Cant create order for non active restaurant'));
        }

        $order = new Order();
        $order->uwagi = strip_tags($orderRequest->remarks);
        $order->userId = null === $identity ? \Yii::$app->user->identity->id : $identity->getId();
        $order->foodId = $orderRequest->foodId;
        $order->restaurantId = $menu->restaurantId;
        $order->status = Order::STATUS_NOT_REALIZED;
        $this->_orderComponent->addOrder($order, $source);

        return $order;
    }
}
