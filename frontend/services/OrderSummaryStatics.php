<?php

namespace frontend\services;

use common\models\Order;
use frontend\models\OrdersSummary;
use frontend\models\OrderSummaryRow;

class OrderSummaryStatics
{
    /**
     * @param Order[] $orders
     * @return OrdersSummary
     */
    public function getStatics(array $orders)
    {
        $statics = new OrdersSummary();
        /** @var OrderSummaryRow[] $result */
        $result = [];
        foreach ($orders as $order) {
            if (!isset($result[$order->restaurantId])) {
                $result[$order->restaurantId] = new OrderSummaryRow();
                $result[$order->restaurantId]->restaurant = $order->restaurants;
                $result[$order->restaurantId]->deliveryCost = $order->restaurants->delivery_price;
            }

            $result[$order->restaurantId]->allOrders += 1;
            $result[$order->restaurantId]->price += $order->getPrice();

            if ($order->isRealized()) {
                $result[$order->restaurantId]->cost += $order->getPriceWithPack();
                $result[$order->restaurantId]->numOfRealizedOrders += 1;
                $result[$order->restaurantId]->pay_amount += $order->pay_amount;
            }
        }
        $statics->setData($result);
        return $statics;
    }
}
