<?php

namespace frontend\tests\unit\services;

use common\models\Order;
use frontend\models\OrdersSummary;
use frontend\services\OrderSummaryStatics;

class OrderSummaryStaticsTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function testCountRealizedOrders()
    {
        $restaurantId = 1;
        $order1 = new Order([
            'status' => Order::STATUS_REALIZED,
            'restaurantId' => $restaurantId
        ]);
        $order2 = new Order([
            'status' => Order::STATUS_NOT_REALIZED,
            'restaurantId' => $restaurantId
        ]);

        $orders = [$order1, $order2];
        $statics = new OrderSummaryStatics();
        $ordersSummary = $statics->getStatics($orders);

        $this->assertInstanceOf(OrdersSummary::class, $ordersSummary);

        $data = $ordersSummary->getData();
        $this->assertCount(1, $data);
        $this->assertSame(1, $data[$restaurantId]->numOfOrders);
    }

    public function testCountAllOrders()
    {
        $restaurantId = 1;
        $order1 = new Order([
            'status' => Order::STATUS_REALIZED,
            'restaurantId' => $restaurantId
        ]);
        $order2 = new Order([
            'status' => Order::STATUS_NOT_REALIZED,
            'restaurantId' => $restaurantId
        ]);

        $orders = [$order1, $order2];
        $statics = new OrderSummaryStatics();
        $ordersSummary = $statics->getStatics($orders);

        $this->assertInstanceOf(OrdersSummary::class, $ordersSummary);

        $data = $ordersSummary->getData();
        $this->assertCount(1, $data);
        $this->assertSame(2, $data[$restaurantId]->allOrders);
    }
}
