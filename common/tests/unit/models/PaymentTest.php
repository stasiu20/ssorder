<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\models\Order;
use common\models\Payment;

class PaymentTest extends Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function testUpdatePayAmountFromPostData(): void
    {
        $order1 = new Order();
        $order1->id = 1;
        $order1->pay_amount = null;

        $order2 = new Order();
        $order2->id = 2;
        $order2->pay_amount = null;
        Payment::updatePayAmountFromPostData([$order1, $order2], [1 => 9.99, 2 => '']);

        $this->assertSame(9.99, $order1->pay_amount);
        $this->assertNull($order2->pay_amount);
    }

    public function testUpdatePayAmountFromPostDataEmptyString(): void
    {
        $order1 = new Order();
        $order1->id = 1;
        $order1->pay_amount = 9.99;

        $order2 = new Order();
        $order2->id = 2;
        $order2->pay_amount = null;
        Payment::updatePayAmountFromPostData([$order1, $order2], [1 => '', 2 => '']);

        $this->assertNull($order1->pay_amount);
        $this->assertNull($order2->pay_amount);
    }

    public function testUpdatePayAmountFromPostDataWithZero(): void
    {
        $order1 = new Order();
        $order1->id = 1;
        $order1->pay_amount = 2;

        $order2 = new Order();
        $order2->id = 2;
        $order2->pay_amount = null;
        Payment::updatePayAmountFromPostData([$order1, $order2], [1 => '0', 2 => '0.00']);

        $this->assertSame(0.0, $order1->pay_amount);
        $this->assertSame(0.0, $order2->pay_amount);
    }
}
