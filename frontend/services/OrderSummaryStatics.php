<?php

namespace frontend\services;

use frontend\models\Order;
use frontend\models\OrderSummaryRow;

class OrderSummaryStatics
{
    /**
     * @param Order[] $orders
     * @return OrderSummaryRow[]
     */
    public function getStatics(array $orders)
    {
        /** @var OrderSummaryRow[] $result */
        $result = [];
        foreach ($orders as $order) {
            if (!isset($result[$order->restaurantId])) {
                $result[$order->restaurantId] = new OrderSummaryRow();
                $result[$order->restaurantId]->restaurant = $order->restaurants;
            }

            if ($order->isRealized()) {
                $result[$order->restaurantId]->price += $order->menu->foodPrice;
            }
        }
        return $result;
    }
}