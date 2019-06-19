<?php

namespace frontend\tests\unit\services;

use common\tests\fake\OrderFake;
use common\models\Order;
use frontend\models\Menu;
use frontend\models\OrdersSummary;
use frontend\services\OrderSummaryStatics;

class OrderSummaryStaticsTestt extends \Codeception\Test\Unit
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
        $order2 = new OrderFake([
            'status' => Order::STATUS_NOT_REALIZED,
            'restaurantId' => $restaurantId,
            'menu' => new Menu([
                'foodPrice' => 5.50
            ])
        ]);

        $orders = [$order1, $order2];
        $statics = new OrderSummaryStatics();
        $ordersSummary = $statics->getStatics($orders);

        $this->assertInstanceOf(OrdersSummary::class, $ordersSummary);

        $data = $ordersSummary->getData();
        $this->assertCount(1, $data);
        $this->assertSame(1, $data[$restaurantId]->numOfRealizedOrders);
    }

    public function testCountAllOrders()
    {
        $restaurantId = 1;
        $order1 = new Order([
            'status' => Order::STATUS_REALIZED,
            'restaurantId' => $restaurantId
        ]);
        $order2 = new OrderFake([
            'status' => Order::STATUS_NOT_REALIZED,
            'restaurantId' => $restaurantId,
            'menu' => new Menu([
                'foodPrice' => 5.50
            ])
        ]);

        $orders = [$order1, $order2];
        $statics = new OrderSummaryStatics();
        $ordersSummary = $statics->getStatics($orders);

        $this->assertInstanceOf(OrdersSummary::class, $ordersSummary);

        $data = $ordersSummary->getData();
        $this->assertCount(1, $data);
        $this->assertSame(2, $data[$restaurantId]->allOrders);
    }

    public function testOrdersPrice()
    {
        $restaurantId = 1;
        $order1 = new Order([
            'status' => Order::STATUS_REALIZED,
            'restaurantId' => $restaurantId,
            'price' => 10.25

        ]);
        $order2 = new OrderFake([
            'status' => Order::STATUS_NOT_REALIZED,
            'restaurantId' => $restaurantId,
            'menu' => new Menu([
                'foodPrice' => 5.50
            ])
        ]);

        $orders = [$order1, $order2];
        $statics = new OrderSummaryStatics();
        $ordersSummary = $statics->getStatics($orders);

        $this->assertInstanceOf(OrdersSummary::class, $ordersSummary);

        $data = $ordersSummary->getData();
        $this->assertSame(15.75, $data[$restaurantId]->price);
    }
}
