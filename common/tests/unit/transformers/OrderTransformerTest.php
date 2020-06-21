<?php

namespace common\tests\unit\transformers;

use Codeception\Test\Unit;
use common\models\Order;
use common\transformers\OrderTransformer;

class OrderTransformerTest extends Unit
{
    public function testTransform(): void
    {
        $data = [
            'id' => 145,
            'foodId' => 34,
            'restaurantId' => 541,
        ];
        $order = new Order();
        $order->load($data, '');

        $transformer = new OrderTransformer();
        $array = $transformer->transform($order);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('foodId', $array);
        $this->assertArrayHasKey('restaurantId', $array);

        $this->assertEquals($order->id, $array['id']);
        $this->assertEquals($order->foodId, $array['foodId']);
        $this->assertEquals($order->restaurantId, $array['restaurantId']);
    }
}
