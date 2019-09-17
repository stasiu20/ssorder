<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\models\Order;

class OrderTest extends Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function testOrderCantBeRealizedIfIsAlreadyRealized(): void
    {
        $order = new Order();
        $order->status = Order::STATUS_REALIZED;

        $this->assertFalse($order->canBeRealized());
    }

    public function testOrderCantBeRealizedIfIsCanceled(): void
    {
        $order = new Order();
        $order->status = Order::STATUS_CANCELED;

        $this->assertFalse($order->canBeRealized());
    }

    public function testOrderCantBeRealizedIfDateIsNotToday(): void
    {
        $order = new Order();
        $order->status = Order::STATUS_NOT_REALIZED;
        $order->data = '2018-01-10 14:02:54';
        $compareToDate = \DateTime::createFromFormat('Y-m-d', '2018-01-1');

        $this->assertFalse($order->canBeRealized($compareToDate));
    }

    public function testOrderCanBeRealized(): void
    {
        $order = new Order();
        $order->status = Order::STATUS_NOT_REALIZED;
        $order->data = '2018-01-10 14:02:54';
        $compareToDate = \DateTime::createFromFormat('Y-m-d', '2018-01-10');

        $this->assertTrue($order->canBeRealized($compareToDate));
    }
}
