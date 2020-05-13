<?php

namespace frontend\tests\unit\helpers;

use common\models\Order;
use common\tests\fake\OrderFake;
use frontend\helpers\OrderCost;
use frontend\models\Menu;
use frontend\models\Restaurants;

class OrderCostTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function testCalculateOrderCost()
    {
        $menu = new Menu();
        $menu->foodPrice = 5;

        $restaurant = new Restaurants();
        $restaurant->delivery_price = 1;

        $order = new OrderFake();
        $order->setRestaurants($restaurant);
        $order->setMenu($menu);
        $order->realizeOrder(1);

        $this->assertEquals(5.34, OrderCost::calculateOrderCost($order, 3, 0));
        $this->assertEquals(5.33, OrderCost::calculateOrderCost($order, 3, 1));
        $this->assertEquals(5.33, OrderCost::calculateOrderCost($order, 3, 2));
    }

    public function testSkipIfOrderIsNotRealized()
    {
        $order = new OrderFake();
        $this->assertNull(OrderCost::calculateOrderCost($order, 3, 0));
    }
}
