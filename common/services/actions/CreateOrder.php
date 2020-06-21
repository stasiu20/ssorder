<?php

namespace common\services\actions;

use common\component\Order as OrderComponent;
use common\enums\OrderSource;
use common\models\Order;
use frontend\models\Menu;
use frontend\modules\apiV1\models\request\CreateOrderRequest;

class CreateOrder
{
    /**
     * @var OrderComponent
     */
    private $_orderComponent;

    public function __construct(OrderComponent $orderComponent)
    {
        $this->_orderComponent = $orderComponent;
    }

    public function run(CreateOrderRequest $orderRequest, OrderSource $source): Order
    {
        $menu = Menu::findOne($orderRequest->foodId);
        if (!$menu) {
            throw new \LogicException(sprintf('Menu #%d not found', $orderRequest->foodId));
        }

        if (!$menu->restaurant->isActive()) {
            throw new \LogicException(sprintf('Cant create order for non active restaurant'));
        }

        $order = new Order();
        $order->uwagi = strip_tags($orderRequest->remarks);
        $order->userId = \Yii::$app->user->identity->id;
        $order->foodId = $orderRequest->foodId;
        $order->restaurantId = $menu->restaurantId;
        $order->status = Order::STATUS_NOT_REALIZED;
        $this->_orderComponent->addOrder($order, $source);

        return $order;
    }
}
