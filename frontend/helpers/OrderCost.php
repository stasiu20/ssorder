<?php

namespace frontend\helpers;

use common\models\Order;
use Money\Money;

class OrderCost
{
    /**
     * @param Order $order
     * @param int $numOfOrders
     * @param int $index
     * @return float|string|void
     */
    public static function calculateOrderCost(Order $order, int $numOfOrders, int $index)
    {
        if (!$order->isRealized()) {
            return;
        }
        $cost = $order->getPriceWithPack();

        $total = Money::PLN((int) round($order->restaurants->delivery_price * 100));
        $allocation = $total->allocateTo($numOfOrders);
        return $cost + ($allocation[$index]->getAmount()) / 100;
    }
}
